@extends('../layouts.master')
@section('content')
<body class="font-poppins text-[#0E0140] pb-[100px] overflow-x-hidden bg-[#0E0140] min-h-screen flex flex-col">
    <x-nav/>
    <div class="flex-1 flex items-center justify-center">
        <div id="Success" class="flex flex-col items-center justify-center gap-[30px] my-auto">
            <div class="flex shrink-0 w-[330px] h-[330px]">
                <img src="{{ asset('assets/backgrounds/success illustration.png') }}" class="object-contain" alt="cover image">
            </div>
            <div class="flex flex-col gap-[14px] text-center max-w-[389px]">
                <p class="font-semibold text-[32px] leading-[48px] text-white">Well, Great Work!</p>
                <p class="leading-[26px] text-white">We have received your application and the recruiter will review in a couple business days</p>
            </div>
            <a href="{{ route('front.index') }}" class="rounded-full p-[14px_24px] bg-[#FF6B2C] font-semibold text-white hover:shadow-[0_10px_20px_0_#FF6B2C66] transition-all duration-300">Explore Other Jobs</a>
        </div>
    </div>
@endsection