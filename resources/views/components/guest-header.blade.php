<div class="flex items-center justify-between bg-primary01 px-4 sm:px-6 lg:px-8">
    <a href="{{ route('welcome') }}" class="shrink-0">
        <x-application-logo class="block w-32 h-auto pt-5" />
    </a>
    <x-nav-link class="sm:-my-px sm:ms-10" :href="route('travel-plans.index')">
            プラン一覧
    </x-nav-link>
</div>