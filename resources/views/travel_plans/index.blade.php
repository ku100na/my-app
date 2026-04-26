<x-app-layout>
    <div class="flex justify-between">
        <x-slot name="title">
            プラン一覧
        </x-slot>
    </div>

    @if (session('success'))
        <p class="mt-2 font-medium text-sm text-green-600">
            {{ session('success') }}
        </p>
    @endif
    
    <div class="flex justify-end">
        <x-card x-data="{open : false}" class="m-1 px-2 py-2 bg-primary04-100 max-w-full">
            <!-- クリック部分 -->
            <div
                class="cursor-pointer flex justify-end"
                @click="open = !open"
            >
                <span x-text="open ? '検索 -' : '検索 +'" class="text-lg font-extrabold text-primary01"></span>
            </div>
            <form  x-show="open" x-transition method="GET" action="{{ route('travel-plans.index') }}">
                @csrf
                <div class="mt-4 grid gap-2 items-center
                    grid-cols-[60px_1fr] 
                    md:grid-cols-[60px_1fr_40px_1fr] 
                    lg:grid-cols-[60px_1fr_40px_1fr_60px_1fr_40px_1fr] ">
                    <x-input-label for="keyword" value="キーワード" class="text-right" />
                    <x-text-input id="keyword" type="text" name="keyword" class="md:col-span-3 lg:col-span-7 lg:w-1/2"
                        value="{{ request('keyword') }}" />

                    <x-input-label for="country" value="国" class="text-right" />
                    <x-text-input id="country" type="text" name="country" value="{{ request('country') }}"/>

                    <x-input-label for="city" value="都市" class="text-right" />
                    <x-text-input id="city" type="text" name="city" value="{{ request('city') }}" />
                    
                    <x-input-label value="予算" class="text-right" />
                    <x-text-input id="min_budget_display" type="text"/>
                    <input id="min_budget" type="hidden" name="min_budget" value="{{ request('min_budget') }}" />
                    <div class="text-center">～</div>
                    <x-text-input id="max_budget_display" type="text"/>
                    <input id="max_budget" type="hidden" name="max_budget" value="{{ request('max_budget') }}"/>
                </div>
                
                <div class="flex justify-end gap-2 mt-2">
                    <input type="hidden" name="type" value="{{ request('type', 'all') }}">
                    <input type="hidden" name="favorited" value="{{ request('favorited') }}">
                    <x-primary-button type="submit">検索</x-primary-button>
                    <x-white-button href="{{ route('travel-plans.index') }}">クリア</x-white-button>
                </div>
            </form>
        </x-card>
    </div>

    <script>
        const minDisplay = document.getElementById('min_budget_display');
        const maxDisplay = document.getElementById('max_budget_display');
        const minHidden = document.getElementById('min_budget');
        const maxHidden = document.getElementById('max_budget');

        // 初期表示
        if(minHidden.value) {
            minDisplay.value = Number(minHidden.value).toLocaleString();
        }
        if(maxHidden.value) {
            maxDisplay.value = Number(maxHidden.value).toLocaleString();
        }

        // 最小金額
        minDisplay.addEventListener('input', function() {
            let value = this.value.replace(/[^\d]/g, '');

            minHidden.value = value;

            if(!value) {
                this.value = '';
                return;
            }
            this.value = Number(value).toLocaleString();
        });
        
        // 最大金額
        maxDisplay.addEventListener('input', function() {
            let value = this.value.replace(/[^\d]/g, '');

            maxHidden.value = value;

            if(!value) {
                this.value = '';
                return;
            }
            this.value = Number(value).toLocaleString();
        });

    </script>

    @auth
    <div class="flex justify-center space-x-2">
        <a href="{{ route('travel-plans.index', array_merge(request()->all(), ['type' => 'mine'])) }}">
            @if(request('type') === 'mine')
                <x-blue-button>自分のプラン</x-blue-button>
            @else
                <x-white-button>自分のプラン</x-white-button>
            @endif
        </a>
        <a href="{{ route('travel-plans.index', array_merge(request()->all(), ['type' => 'all'])) }}">
            @if(request('type') === 'mine')
                <x-white-button>みんなのプラン</x-white-button>
            @else
                <x-blue-button>みんなのプラン</x-blue-button>
            @endif
        </a>
        <a href="{{ route('travel-plans.index', array_merge(request()->all(), ['favorited' => request('favorited') === '1' ? null : 1])) }}" class="flex items-center">
            @if(request('favorited') === '1')
                <ion-icon name="heart" class="text-red-500 text-2xl"></ion-icon>
            @else
                <ion-icon name="heart-outline" class="text-2xl"></ion-icon>
            @endif
        </a>
    </div>
    @endauth

    <div class="p-6 flex flex-col">
        <div class="hidden sm:block">
            <table class="mx-auto bg-base border border-primary03 p-8">
                <thead class="bg-primary03 text-primary01">
                    <tr>
                        <th class="px-4 py-2">プラン名</th>
                        <th class="px-4 py-2">国</th>
                        <th class="px-4 py-2">都市</th>
                        <th class="px-4 py-2">期間</th>
                        <th class="px-4 py-2">ステータス</th>
                        <th class="px-4 py-2"></th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plans as $plan)
                    <form method="POST" action="{{ route('travel-plans.toggleFavorite', $plan) }}">
                        @csrf
                        <tr>
                            <td class="px-4 py-2">
                            <div class="flex items-center gap-2">
                                @auth
                                    <button type="submit" class="flex items-center">
                                        @if($user->favorites->contains('id', $plan->id))
                                            <ion-icon name="heart" class="text-red-500 text-2xl"></ion-icon>
                                        @else
                                            <ion-icon name="heart-outline" class="text-2xl"></ion-icon>
                                        @endif
                                    </button>
                                @endauth
                                <div>{{ $plan->title }}</div>
                            </div>
                            </td>
                            <td class="px-4 py-2">{{ $plan->country }}</td>
                            <td class="px-4 py-2">{{ $plan->city }}</td>
                            <td class="px-4 py-2">{{ $plan->start_date }} ~ {{ $plan->end_date }}</td>
                            <td class="px-4 py-2">
                                @if($plan->status === 'planned')
                                    予定
                                @elseif($plan->status === 'completed')
                                    完了
                                @endif
                            </td>
                            <td class="px-4 py-2"><x-primary-button href="{{ route('travel-plans.show', $plan->id) }}">詳細</x-primary-button></td>
                            @auth
                                @if($plan->user_id === auth()->id())
                                    <td class="px-4 py-2"><x-primary-button href="{{ route('travel-plans.edit', $plan->id) }}">編集</x-primary-button></td>
                                @endif
                            @endauth
                        </tr>
                    </form>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="sm:hidden space-y-4">
            @foreach($plans as $plan)
                <form method="POST" action="{{ route('travel-plans.toggleFavorite', $plan) }}">
                    @csrf
                    <div class="bg-base shadow-lg rounded-lg overflow-hidden">
                        <div class="bg-primary03 font-bold w-full p-2 flex justify-between">
                            <div>{{ $plan->title }}</div>
                            @auth
                                <button type="submit">
                                    @if($user->favorites->contains('id', $plan->id))
                                        <ion-icon name="heart" class="text-red-500 text-2xl"></ion-icon>
                                    @else
                                        <ion-icon name="heart-outline" class="text-2xl"></ion-icon>
                                    @endif
                                </button>
                            @endauth
                        </div>
                        
                        <div class="p-4 text-gray-800">
                            <div>{{ $plan->city }}</div>
                            <div>{{ $plan->start_date }} ~ {{ $plan->end_date }}</div>
                            <div>
                                @if($plan->status === 'planned')
                                    予定
                                @else
                                    完了
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-2 ml-4 mb-4">
                            <x-primary-button href="{{ route('travel-plans.show', $plan->id) }}">詳細</x-primary-button>
                            @auth
                                @if($plan->user_id === auth()->id())
                                    <x-primary-button href="{{ route('travel-plans.edit', $plan->id) }}">編集</x-primary-button>
                                @endif
                            @endauth
                        </div>
                    </div>
                </form>
            @endforeach
        </div>
        
        <div class="mt-4">
            {{ $plans->appends(request()->query())->links()}}
        </div>

        @auth
        <div class="mt-8">
            <x-primary-button href="{{ route('travel-plans.create') }}">
                ＋作成
            </x-primary-button>
        </div>
        @endauth
    </div>
</x-app-layout>