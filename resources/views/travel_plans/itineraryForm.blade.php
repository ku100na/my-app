<div class="font-bold text-xl text-primary01">日程</div>
<div class="pl-4 space-y-4">
    <div id="plan-container" class="pl-2">
    </div>
    <x-white-button id="add-day">＋日程追加</x-white-button>


    <script>

    /* =========================
     スポット生成
    ========================= */
    function createSpot(dayDiv, dayIndex, spotIndex, spot = {}) {

        const spotsDiv = dayDiv.querySelector('.spots');

        const spotDiv = document.createElement('div');
        spotDiv.classList.add('spot');

        spotDiv.innerHTML = `
            <x-card class="bg-primary03 space-y-4 mb-1 relative">

                <x-white-button type="button" class="absolute top-2 right-2 remove-spot">
                    スポット削除
                </x-white-button>

                <div>
                    <div class="flex items-center space-x-2">
                        <x-input-label value="スポット名" />
                        <x-text-input type="text"
                            name="days[${dayIndex}][spots][${spotIndex}][name]"
                            value="${spot.name ?? ''}" />
                    </div>
                </div>
                <div class="error-name text-sm text-red-600"></div>

                <div>
                    <div class="flex items-center space-x-2">
                        <x-input-label value="所要時間" />

                        <select name="days[${dayIndex}][spots][${spotIndex}][hours]" class="border-primary03 border-4 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            ${[0,1,2,3,4,5,6].map(h =>
                                `<option value="${h}" ${spot.hours == h ? 'selected' : ''}>${h}</option>`
                            ).join('')}
                        </select>時間

                        <x-text-input type="number"
                            min="0" max="59" step="5"
                            name="days[${dayIndex}][spots][${spotIndex}][minutes]"
                            value="${spot.minutes ?? ''}" />
                        分
                    </div>
                </div>
                <div class="error-hours text-sm text-red-600"></div>
                <div class="error-minutes text-sm text-red-600"></div>
                
                <div>
                    <div class="flex items-center space-x-2">
                        <x-input-label value="メモ" class="w-8" />
                        <x-textarea class="w-full" name="days[${dayIndex}][spots][${spotIndex}][review]">${spot.review ?? ''}</x-textarea>
                    </div>
                </div>
                <div class="error-review text-sm text-red-600"></div>
            </x-card>
        `;

        spotsDiv.appendChild(spotDiv);
    }


    /* =========================
     日程生成
    ========================= */
    function createDay(day = {}, dayIndex) {

        const container = document.getElementById('plan-container');

        const dayDiv = document.createElement('div');
        dayDiv.classList.add('day');
        dayDiv.dataset.day = dayIndex + 1;
        dayDiv.dataset.spotIndex = 0;

        dayDiv.innerHTML = `
            <label>Day${dayIndex + 1}：</label>

            <x-text-input type="text"
                name="days[${dayIndex}][title]"
                placeholder="タイトル"
                value="${day.title ?? ''}" />

            <x-white-button type="button" class="ml-2 remove-day">
                日程削除
            </x-white-button>

            <div class="error-title text-sm text-red-600 space-y-1"></div>
            
            <div class="spots"></div>

            <x-white-button type="button" class="ml-6 add-spot mb-8">
                ＋スポット追加
            </x-white-button>
        `;

        container.appendChild(dayDiv);

        // スポット復元
        (day.spots || []).forEach((spot, i) => {
            createSpot(dayDiv, dayIndex, i, spot);
        });

        dayDiv.dataset.spotIndex = (day.spots || []).length;

        return dayDiv;
    }


    /* =========================
     日程追加ボタン
    ========================= */
    document.getElementById('add-day').addEventListener('click', function () {

        const dayIndex = document.querySelectorAll('.day').length;

        const dayDiv = createDay({}, dayIndex);
        createSpot(dayDiv, dayIndex, 0, {});
    });


    /* =========================
     スポット追加（イベント委任）
    ========================= */
    document.addEventListener('click', function (e) {

        const addSpotBtn = e.target.closest('.add-spot');
        if (addSpotBtn) {

            const dayDiv = addSpotBtn.closest('.day');
            const dayIndex = Array.from(document.querySelectorAll('.day')).indexOf(dayDiv);

            const spotIndex = dayDiv.querySelectorAll('.spot').length;

            createSpot(dayDiv, dayIndex, spotIndex, {});
        }
    });


    /* =========================
     削除処理
    ========================= */
    document.addEventListener('click', function (e) {

        // スポット削除
        if (e.target.closest('.remove-spot')) {
            e.target.closest('.spot')?.remove();
            reindexDays();
        }

        // 日程削除
        if (e.target.closest('.remove-day')) {
            e.target.closest('.day')?.remove();
            reindexDays();
        }
    });

    /* =========================
     エラー処理
    ========================= */
    const errors = @json($errors->toArray());

    function showErrors(dayDiv, dayIndex) {

        // ===== Day title =====
        const titleKey = `days.${dayIndex}.title`;
        if (errors[titleKey]) {
            const el = dayDiv.querySelector('.error-title');
            if (el) el.textContent = errors[titleKey][0];
        }

        // ===== Spots =====
        const spots = dayDiv.querySelectorAll('.spot');

        spots.forEach((spotDiv, spotIndex) => {

            const mappings = {
                name: '.error-name',
                hours: '.error-hours',
                minutes: '.error-minutes',
                review: '.error-review'
            };

            Object.keys(mappings).forEach(field => {

                const key = `days.${dayIndex}.spots.${spotIndex}.${field}`;

                if (errors[key]) {
                    const el = spotDiv.querySelector(mappings[field]);
                    if (el) el.textContent = errors[key][0];
                }
            });
        });
    }
    /* =========================
     ページロード時の復元
    ========================= */
    window.addEventListener('load', () => {

        const oldDays = @json(old('days') ?? $days ?? []);

        const container = document.getElementById('plan-container');

        oldDays.forEach((day, i) => {
            const dayDiv = createDay(day, i);
            showErrors(dayDiv, i);
        });
    });

    function reindexDays() {

        const days = document.querySelectorAll('.day');

        days.forEach((dayDiv, dayIndex) => {

            // ===== Day番号 =====
            dayDiv.dataset.day = dayIndex + 1;

            // ===== ラベル =====
            const label = dayDiv.querySelector('label');
            if (label) label.textContent = `Day${dayIndex + 1}：`;

            // ===== title =====
            const titleInput = dayDiv.querySelector('input[name*="[title]"]');
            if (titleInput) {
                titleInput.name = `days[${dayIndex}][title]`;
            }

            // ===== spots =====
            const spots = dayDiv.querySelectorAll('.spot');

            spots.forEach((spotDiv, spotIndex) => {

                const inputs = spotDiv.querySelectorAll('input, textarea, select');

                inputs.forEach(el => {

                    if (el.name.includes('[name]')) {
                        el.name = `days[${dayIndex}][spots][${spotIndex}][name]`;
                    }

                    if (el.name.includes('[hours]')) {
                        el.name = `days[${dayIndex}][spots][${spotIndex}][hours]`;
                    }

                    if (el.name.includes('[minutes]')) {
                        el.name = `days[${dayIndex}][spots][${spotIndex}][minutes]`;
                    }

                    if (el.name.includes('[review]')) {
                        el.name = `days[${dayIndex}][spots][${spotIndex}][review]`;
                    }
                });
            });

            // ===== spot数更新 =====
            dayDiv.dataset.spotIndex = spots.length;
        });
    }
    </script>
</div>