<div >
<livewire:appointment.doctor :$selectedDoctor />
    <!-- Desktop male & female flex section start  -->
    {{-- @livewire('appointment.doctor') --}}
    <!-- Desktop male & female flex section end  -->

    <!-- Choose Your Doctor section end  -->

    <!-- June section start  -->
<livewire:appointment.month :$selectedDate :$days />    <!-- June section end  -->
<livewire:appointment.slot :$availableTimeSlots :$selectedDate :$selectedTime/>    <!-- June section end  -->

    {{-- @livewire('appointment.slot') --}}
    @if (session()->has('message'))

    <div class="fixed right-10 z-20 px-3 py-2 mx-auto text-white bg-red-500 w-fit bottom-10 ">

        {{ session('message') }}

    </div>
    @endif

</div>