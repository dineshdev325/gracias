<div x-data>
    {{-- @dd($available_timeSlots) --}}
    {{-- MORNING SLOTS --}}
    <div class="mt-6 lg:mt-16 2xl:mx-96">
        @foreach ($timeSlots as $timeSlot)
        @if ($timeSlot<=strtotime('12:00:00')) <div class="mb-4 ">
            <h1 class="font-medium ">Morning Slots</h1>
    </div>
    @break
    @endif
    @endforeach
    <div class="grid grid-cols-3 gap-4 lg:gap-10 lg:grid-cols-6 lg:mt-10">
        @foreach ($timeSlots as $timeSlot)

        @if ($timeSlot<strtotime('12:00:00')) 
        <button @click="$dispatch('setTime', { selectedTime: {{$timeSlot}} })"
            class="py-2 text-xs text-center border cursor-pointer"
            
             :style="
         !$wire.availableTimeSlots.includes('{{date('H:i:s',$timeSlot)}}') ||({{strtotime(date(" H:i:s",time()))}}>
            {{strtotime(date('H:i:s',$timeSlot))}} &&
            $wire.selectedDate=='{{$currentTime->format('o-m-j')}}')? 'border:D1D5D8;color:#6B7280;cursor: not-allowed;' :
            $wire.selectedTime=='{{date('H:i:s',$timeSlot)}}'?
            'background-color:#212245;color:white;':'border-color:#878787'"
            
            :disabled="!$wire.availableTimeSlots.includes('{{date('H:i:s',$timeSlot)}}') || ({{strtotime(date("H:i:s",time()))}} >
            {{strtotime(date('H:i:s',$timeSlot))}} &&
            $wire.selectedDate=='{{$currentTime->format('o-m-j')}}')? true :false"
            >
            {{date('h:i A',$timeSlot)}}</button>
            @endif
            @endforeach
    </div>

    {{-- AFTERNOON SLOT --}}
    <div class="mt-6 lg:mt-16 2xl:mx-96">
        @foreach ($timeSlots as $timeSlot)
        @if ($timeSlot<=strtotime('17:00:00')) <div class="mb-4 ">
            <h1 class="font-medium ">Afternon Slots</h1>
    </div>
    @break
    @endif
    @endforeach
    <div class="grid grid-cols-3 gap-4 lg:gap-10 lg:grid-cols-6 lg:mt-10">
        @foreach ($timeSlots as $timeSlot)
        @if ($timeSlot<strtotime('17:00:00') && $timeSlot>=strtotime('12:00:00'))
            <button 
            @click="$dispatch('setTime', { selectedTime: {{$timeSlot}} })"
                class="py-2 text-xs text-center border cursor-pointer" :style="
        
    !$wire.availableTimeSlots.includes('{{date('H:i:s',$timeSlot)}}') ||({{strtotime(date(" H:i:s",time()))}}>
                {{strtotime(date('H:i:s',$timeSlot))}} && $wire.selectedDate=='{{$currentTime->format('o-m-j')}}') ?
                'border:D1D5D8;color:#6B7280;cursor: not-allowed;' :
                $wire.selectedTime=='{{date('H:i:s',$timeSlot)}}'?
                'background-color:#212245;color:white;':'border-color:#878787'"
                :disabled="!$wire.availableTimeSlots.includes('{{date('H:i:s',$timeSlot)}}') ||
                ({{strtotime(date("H:i:s",time()))}} > {{strtotime(date('H:i:s',$timeSlot))}} &&
                $wire.selectedDate=='{{$currentTime->format('o-m-j')}}')? true :false"
                >
                {{date('h:i A',$timeSlot)}} </button>
            @endif
            @endforeach
    </div>
    {{-- Evening SLOT --}}
    <div class="mt-6 lg:mt-16 2xl:mx-96">
        @foreach ($timeSlots as $timeSlot)
        @if ($timeSlot<=strtotime('21:00:00')) <div class="mb-4 ">
            <h1 class="font-medium ">Evening Slots</h1>
    </div>
    @break
    @endif
    @endforeach
    <div class="grid grid-cols-3 gap-4 lg:gap-10 lg:grid-cols-6 lg:mt-10">
        @foreach ($timeSlots as $timeSlot)
        @if ($timeSlot<=strtotime('24:00:00') && $timeSlot>=strtotime('17:00:00'))
            <button @click="$dispatch('setTime', { selectedTime: {{$timeSlot}} })"
                class="py-2 text-xs text-center border cursor-pointer" :style="
   !$wire.availableTimeSlots.includes('{{date('H:i:s',$timeSlot)}}') ||({{strtotime(date(" H:i:s",time()))}}>
                {{strtotime(date('H:i:s',$timeSlot))}} &&
                $wire.selectedDate=='{{$currentTime->format('o-m-j')}}') ? 'border:D1D5D8;color:#6B7280;cursor: not-allowed;' :
                $wire.selectedTime=='{{date('H:i:s',$timeSlot)}}'?
                'background-color:#212245;color:white;':'border-color:#878787'"
                :disabled="!$wire.availableTimeSlots.includes('{{date('H:i:s',$timeSlot)}}') ||
                ({{strtotime(date("H:i:s",time()))}} > {{strtotime(date('H:i:s',$timeSlot))}} &&
                $wire.selectedDate=='{{$currentTime->format('o-m-j')}}')? true :false"
                >
                {{date('h:i A',$timeSlot)}} </button>
            @endif
            @endforeach
    </div>
    <!-- Button section start  -->
    <div class="flex justify-center mt-10 lg:mt-20">
        <button @click="$dispatch('goToPatient')"
            class="text-black lg:w-[40%] bg-[#A4CB6A] font-semibold mb-6 w-full text-center py-3 rounded-lg border-[#212245] border-t border-r-4 border-b-4 border-l">Proceed
            to Next</button>
    </div>
    <!-- Button section end  -->
</div>