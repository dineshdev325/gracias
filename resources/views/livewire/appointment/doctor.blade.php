<div x-data>
    <div class="justify-between gap-16 md:flex 2xl:mx-96 lg:mt-7">
        @foreach ($doctors as $doctor)
        <!-- Male section start  -->
        {{-- border-[#212245] border-t border-r-4 border-b-4 border-l --}}
        <div class="flex justify-between flex-1 px-5 py-5 mt-5 border rounded-lg"
            :class="$wire.selectedDoctor=={{$doctor->id}}? 'border-[#212245] border-t border-r-4 border-b-4 border-l':'shadow-[0px_3px_8px_0px_rgba(0,0,0,0.14)]'"
            @click="$dispatch('setDoctor', { selectedDoctor: {{$doctor->id}} });$wire.selectedDoctor={{$doctor->id}}" >
            {{-- selected_doctor={{$doctor->id}}; --}}
            <div class="flex gap-10">
                <img src="{{$doctor->image}}" alt="" class="w-20 h-20 bg-top bg-cover rounded-full">
                <div class="">
                    <h3 class="text-sm font-medium md:font-bold">{{$doctor->name}}</h3>
                    <span class=" text-xs text-[#6B7280]">{{$doctor->specialization}}</span>
                    <h6 class="mt-3 text-sm font-semibold "> $ {{$doctor->amount}}</h6>
                </div>
            </div>
            <div>
                <input type="checkbox" @change="$dispatch('setDoctor', { selectedDoctor: {{$doctor->id}} });$wire.selectedDoctor={{$doctor->id}}" name="" id=""
                    class=" w-4 h-4 accent-[#212245]" :checked="$wire.selectedDoctor=={{$doctor->id}}? true :false">
            </div>
        </div>
        <!-- Male section end  -->


        @endforeach
    </div>
</div>