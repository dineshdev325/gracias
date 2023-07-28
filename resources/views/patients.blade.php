<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- font family -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    @vite('resources/css/app.css')
   

    @livewireStyles()
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"
  />
  <script async src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
</head>


<body>
    <div class=" lg:px-80 lg:pt-14 lg:pb-28">
        <!-- main div open  -->
        <div class="container mx-auto lg:bg-white rounded-xl">
            <!-- parent div open  -->
            <div class="flex items-center gap-3 py-6 ml-4 lg:py-0 lg:pt-3">

                <a href="/appointment"><img src="/assets/icons/left-arrow.svg" alt=""
                        class="w-5 cursor-pointer lg:hidden"></a>
                <h1 class="text-lg font-bold font-title">Your Information</h1>

            </div>
        <div class="lg:border-t lg:border-t-[Grey/300] lg:mt-3 lg:ml-2 lg:mr-2"></div>
            <div class="lg:ml-2 lg:mr-2 lg:mt-3">
            <livewire:patients.form />
            </div>

            {{-- @livewire('patients.form') --}}

        </div> <!-- parent div open  -->
    </div> <!-- main div close  -->
    {{-- @vite('resources/js/app.js') --}}
    @livewireScripts()
    @livewireScriptConfig()

</body>

</html>