<x-app-layout>
    <x-slot name="title">
        プラン詳細
    </x-slot>

    <div class="space-y-3">
        <x-card class="inline-block">
            <div class="inline-block font-bold text-xl text-base p-3 bg-primary04-500 rounded-md">{{ $travelPlan->title }}</div>

            <div class="lg:flex lg:space-x-8">
                <img 
                    src="{{ $travelPlan->photo_url ? asset('storage/photos/' . $travelPlan->photo_url) : asset('images/default_photo.png') }}"
                    alt="旅行写真"
                    class="mt-1 block max-w-md w-full h-auto"
                >
                <div class="grid grid-cols-[100px_1fr] gap-y-2 mt-4">
                    <div class="text-primary04-500 font-bold">旅行先</div>
                    <div class="text-gray-800">
                        {{ $travelPlan->country }}&nbsp;&nbsp;&nbsp;
                        {{ $travelPlan->city }}
                    </div>

                    <div class="text-primary04-500 font-bold">旅行期間</div>
                    <div class="text-gray-800">{{ $travelPlan->start_date }}～{{ $travelPlan->end_date }}</div>
                    
                    <div class="text-primary04-500 font-bold">ステータス</div>
                    <div class="text-gray-800">
                        @if($travelPlan->status === 'planned')
                            予定
                        @elseif($$travelPlan->status === 'completed')
                            完了
                        @endif
                    </div>

                    <div class="text-primary04-500 font-bold">概要</div>
                    <div class="text-gray-800">概要</div>
                </div>
            </div>
        </x-card>
        
        <div>
            <div class="font-bold text-xl">日程</div>
            <div>
                @foreach($travelPlan->days as $day)
                <x-card x-data="{ open: {{$loop->first ? 'true' : 'false'}} }" class="bg-primary04-100 max-w-2xl">
                    <!-- クリック部分 -->
                    <div 
                        class="flex justify-between items-center cursor-pointer"
                        @click="open = !open"
                    >
                        <div class="font-bold pb-2">
                            Day{{ $day->day_number }}
                        <div class="text-sm text-gray-500 pl-1">
                            {{ $day->spots->count() }}スポット
                        </div>
                        </div>
                        <div>
                            <span x-show="!open" class="text-2xl font-extrabold">+</span>
                            <span x-show="open" class="text-2xl font-extrabold">-</span>
                        </div>
                    </div>
                    
                    <div x-show="open" x-transition class="space-y-2">
                        @foreach($day->spots as $spot)
                        <div class="border rounded-lg p-4 bg-base">
                            <div class="font-bold">
                                {{ $spot->name }}
                            </div>
                            <div class="pl-4">
                                <div>所要時間：{{ $spot->duration_text }}</div>
                                <div>メモ：{{ $spot->revew }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </x-card>
                @endforeach
            </div>
        </div>

        <hr class="border-t-2 border-dashed border-primary01">
        <div class="font-bold text-xl">旅行後の記録</div>
        <div class="pl-8">
            <div>感想：{{ $travelPlan->travelRecord->review }}</div>
            <div>費用：{{ number_format($travelPlan->travelRecord->cost) }}円</div>
        </div>
    </div>

    <x-primary-button class="mt-8">編集</x-primary-button>
</x-app-layout>