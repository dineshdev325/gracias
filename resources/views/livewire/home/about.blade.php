<div id="docters">
    <div class="">
        <div class="mt-10 md:pt-12 md:text-center">
            <h1 class="text-xl font-bold font-title ">About the Doctors</h1>
        </div>



        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-48 gap-y-5 md:mt-16">
            <!--grid-->
            <!-- 1 -->
        @foreach ($doctors as $doctor)
            <div class="mt-10 md:mt-0">
                <div class="cursor-pointer">
                    <img src="{{$doctor->image}}" alt="" class="object-cover bg-top h-[500px] w-full rounded-tl-md rounded-tr-md">
                </div>


                <div class=" border-[#878787] border border-t-0 px-5   mb-4  rounded-b-lg ">
                    <h2 class="pt-5 text-xl font-extrabold">Dr. {{$doctor->name}}</h2>
                    <p class="text-[#878787] pt-5 ">{{$doctor->specialization}}</p>
                    <!-- button -->
                    <div class="flex justify-center mt-8 ">
                        <button
                        wire:click='goToAppointment({{$doctor->id}})'
                            class="text-black md:w-5/6 bg-[#A4CB6A] font-semibold mb-6 w-full text-center py-3 rounded-lg border-[#212245] border-t border-r-4 border-b-4 border-l">Book
                            With Dr. {{$doctor->name}}</button>
                    </div>
                </div>

            </div>
@endforeach
            
        </div>
        <!--grid-->

    </div>
</div>