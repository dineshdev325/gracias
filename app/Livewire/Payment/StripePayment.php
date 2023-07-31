<?php

namespace App\Livewire\Payment;

use Livewire\Component;

use App\Models\Consultation;

use Stripe\StripeClient;
use App\Models\Payment as ModelsPayment;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Error;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twilio\Rest\Client;


class StripePayment extends Component
{

    public $consultation_details;
    public $consultation_id;
    public $patient_id;
    public $amount;
    public $patient;
    public $selectedDate;
    public $selectedTime;

    public function makePayment()
    {
        $this->consultation_id = session()->get('consultationId');
        $this->consultation_details = Consultation::with('patient', 'timeSlots', 'timeSlots.doctor')->where('id', '=', $this->consultation_id)->get();
        $this->amount = $this->consultation_details[0]->timeSlots->doctor->amount;
        $this->patient_id = Consultation::where('id', $this->consultation_id)->pluck('patient_details_id');

        //CREATE STRIPE CLIENT
        $stripe = new StripeClient(
            env('STRIPE_SECRET_KEY')
        );

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'inr',
                    'product_data' => [
                        'name' => $this->consultation_details[0]->timeSlots->doctor->name,
                    ],
                    'unit_amount' => $this->amount * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('appointment'),
        ]);

        //CREATE PAYMENT
        $payment = ModelsPayment::create([
            'patient_details_id' => $this->patient_id[0],
            'consultations_id' => $this->consultation_id,
            'amount' => $this->amount,
            'transaction_id' => $checkout_session->id,
            'payment_status' => 'pending',
            'payment_date' => Carbon::now()

        ]);

        return redirect()->to($checkout_session->url);
    }

    public function success()
    {
        $session_id = Request::get('session_id');
        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET_KEY')
        );

        $this->selectedDate = session()->get('selectedDate');
        $this->selectedTime = date('h:i A', strtotime(session()->get('selectedTime')));

        try {

            $session = $stripe->checkout->sessions->retrieve($session_id);
            $payment = ModelsPayment::where('transaction_id', 'like', $session_id)->first(); //->where('payment_status', 'pending')
            $payment->payment_status = 'success';
            $payment->save();

            // GET PAYMENT DETAILS
            $this->patient = ModelsPayment::where('transaction_id', 'like', $session_id)->get();
            $payment_details = ModelsPayment::with('patient', 'consultation', 'consultation.timeSlots.doctor')->where('transaction_id', 'like', $session_id)->get();
            $patient_detail = $payment_details[0]->patient;
            $consultation_detail = $payment_details[0]->consultation;
            $doctor_detail = $payment_details[0]->consultation->timeSlots->doctor;

            // UPDATE TIME SLOT
            $date = session()->get('selectedDate');
            $time = session()->get('selectedTime');

            //UPDATE AVAILABLE
            $time_slot = TimeSlot::where('time', $time)->whereDate('date', '=', $date)->get();
            $time_slot[0]->is_available = 0;
            $time_slot[0]->save();
            
            //UPDATE PAID
            $consultation = Consultation::find($consultation_detail->id);
            $consultation->is_paid = 1;
            $consultation->save();

            //CREATE TWILIO MESSAGE
            $sid = getenv("TWILIO_ACCOUNT_SID");
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilioNumber = env('TWILIO_PHONE_NUMBER');  // Your Twilio Phone Number

            $twilio = new Client($sid, $token);
            $message = $twilio->messages
                ->create(
                    "whatsapp:+916385477692", // to
                    array(
                        "from" => 'whatsapp:' . $twilioNumber,
                        "body" =>  "
Hello $patient_detail->full_name,

We hope this message finds you well. We are pleased to confirm your online doctor appointment. Here are the details:

Date: $this->selectedDate
Time: $this->selectedTime 
Doctor: $doctor_detail->name
Specialty:  $doctor_detail->specialization
Platform: Whatsapp

Please make sure to be available a few minutes before the scheduled time to ensure a smooth virtual consultation.

In case of any questions or if you need to reschedule the appointment, feel free to reach out to us at contact@graciaclinic.com.

Thank you for choosing us for your healthcare needs. We look forward to providing you with the best medical care.

Best regards, Gracias."
                    )
                );
        } catch (Error $e) {
            throw new NotFoundHttpException();
        }
        return view('detail-page', ['doctorDetail' => $doctor_detail]);
    }
    public function render()
    {
        return view('livewire.payment.stripe-payment');
    }
}
