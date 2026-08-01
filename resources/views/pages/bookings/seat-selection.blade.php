@extends('layouts.app')

@section('title', 'Select Seats')

@section('content')

@php
    $showtime = $showtime;
    $movie = $showtime->movie;
    $hall = $showtime->hall;
    $reserved = $reserved ?? [];
@endphp

<div class="pt-24 px-6 max-w-7xl mx-auto">
    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="glass-card rounded-xl p-6">
                <div class="text-center mb-6">
                    <svg class="w-full screen-curve" viewBox="0 0 800 60"><path d="M0,50 Q400,0 800,50" fill="none" stroke="#E50914" stroke-linecap="round" stroke-width="4"></path></svg>
                    <p class="text-sm text-gray-400 uppercase tracking-widest mt-2">Screen</p>
                </div>

                <div id="seat-grid" class="min-h-[420px]"></div>

                <div class="mt-6 border-t pt-4 flex gap-6 justify-center text-sm text-gray-400">
                    <div class="flex items-center gap-2"><div class="w-4 h-4 bg-gray-600 rounded-sm"></div> Available</div>
                    <div class="flex items-center gap-2"><div class="w-4 h-4 bg-red-600 rounded-sm"></div> Selected</div>
                    <div class="flex items-center gap-2"><div class="w-4 h-4 bg-gray-800 rounded-sm"></div> Reserved</div>
                    <div class="flex items-center gap-2"><div class="w-4 h-4 bg-yellow-500 rounded-sm"></div> VIP</div>
                    <div class="flex items-center gap-2"><div class="w-8 h-4 bg-purple-600 rounded-sm"></div> Couple</div>
                </div>
            </div>
        </div>

        <aside class="space-y-4">
            <div class="glass-card rounded-xl p-4">
                <div class="flex gap-3">
                    <img src="{{ $movie->poster ? (preg_match('/^https?:\/\//', $movie->poster) ? $movie->poster : asset('storage/' . $movie->poster)) : asset('images/poster-placeholder.jpg') }}" alt="poster" class="w-20 h-28 rounded">
                    <div>
                        <h3 class="font-bold">{{ $movie->title }}</h3>
                        <p class="text-sm text-gray-400">{{ $showtime->format ?? 'IMAX' }} • {{ $movie->language ?? 'EN' }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ \Illuminate\Support\Carbon::parse($showtime->start_time)->format('D, M d • H:i') ?? '' }} • {{ $hall->name ?? 'Hall' }}</p>
                    </div>
                </div>
            </div>

            <div class="glass-card rounded-xl p-4">
                <p class="text-xs text-gray-400 uppercase">Selected Seats</p>
                <div id="selection-list" class="min-h-[60px] mt-2 text-sm text-gray-300 italic">No seats selected yet</div>
            </div>

            <div class="glass-card rounded-xl p-4">
                <div class="flex justify-between items-center mb-2">
                    <div class="text-xs text-gray-400 uppercase">Total Amount</div>
                    <div id="total-price" class="text-xl font-extrabold text-red-600">$0.00</div>
                </div>
                <button id="continue-btn" class="w-full bg-red-600 text-white py-3 rounded disabled:opacity-50" disabled>Continue</button>
            </div>
        </aside>
    </div>
</div>

<script>
    const seatGrid = document.getElementById('seat-grid');
    const selectionList = document.getElementById('selection-list');
    const totalPriceEl = document.getElementById('total-price');
    const continueBtn = document.getElementById('continue-btn');
    let selectedSeats = [];

    const SEAT_PRICES = { regular: 15.00, vip: 25.00, couple: 45.00 };

    const config = {
        rows: ['A','B','C','D','E','F','G','H','I','J'],
        cols: 14,
        reserved: @json($reserved),
        vipRows: ['C','D'],
        coupleRows: ['J'],
        aisleAfter: [3,10]
    };

    function initGrid() {
        config.rows.forEach(rowLabel => {
            const rowDiv = document.createElement('div');
            rowDiv.className = 'flex items-center gap-2 mb-2';

            const label = document.createElement('div');
            label.className = 'w-6 text-center text-sm text-gray-400 mr-3';
            label.innerText = rowLabel;
            rowDiv.appendChild(label);

            for (let i=1;i<=config.cols;i++){
                const id = `${rowLabel}${i}`;
                const isReserved = config.reserved.includes(id);
                const isVIP = config.vipRows.includes(rowLabel) && i>4 && i<11;
                const isCouple = config.coupleRows.includes(rowLabel);

                if (isCouple && i%2===0) continue; // skip paired cell

                const seat = document.createElement('div');
                seat.dataset.id = id;
                let type = 'regular';
                let classes = 'w-6 h-6 rounded-sm';

                if (isReserved){ type='reserved'; classes += ' bg-gray-800'; }
                else if (isVIP){ type='vip'; classes += ' bg-yellow-500 cursor-pointer'; }
                else if (isCouple){ type='couple'; classes += ' bg-purple-600 w-12 h-6 cursor-pointer'; }
                else { classes += ' bg-gray-600 cursor-pointer'; }

                seat.className = classes;
                seat.dataset.type = type;
                seat.dataset.price = SEAT_PRICES[type] || SEAT_PRICES.regular;

                if (type !== 'reserved') seat.onclick = () => toggleSeat(seat);

                rowDiv.appendChild(seat);

                if (config.aisleAfter.includes(i)){
                    const aisle = document.createElement('div'); aisle.className='w-6'; rowDiv.appendChild(aisle);
                }
            }

            seatGrid.appendChild(rowDiv);
        });
    }

    function toggleSeat(el){
        const id = el.dataset.id;
        const idx = selectedSeats.findIndex(s=>s.id===id);
        if (idx>-1){ selectedSeats.splice(idx,1); el.classList.remove('ring-2','ring-red-500'); }
        else { selectedSeats.push({id:id, type:el.dataset.type, price:parseFloat(el.dataset.price)}); el.classList.add('ring-2','ring-red-500'); }
        updateSummary();
    }

    function updateSummary(){
        if (selectedSeats.length===0){ selectionList.innerHTML='<p class="text-gray-400 italic">No seats selected yet</p>'; totalPriceEl.innerText='$0.00'; continueBtn.disabled=true; return; }
        selectionList.innerHTML=''; let total=0;
        selectedSeats.forEach(s=>{ const chip=document.createElement('div'); chip.className='inline-block bg-red-600 text-white px-2 py-1 rounded mr-2 mb-2 text-sm'; chip.innerText=s.id; selectionList.appendChild(chip); total+=s.price; });
        totalPriceEl.innerText=`$${total.toFixed(2)}`; continueBtn.disabled=false;
    }

    initGrid();
    // pre-mark reserved seats visually
    config.reserved.forEach(id=>{ const el=document.querySelector(`[data-id="${id}"]`); if(el) el.classList.remove('cursor-pointer'); });
    
</script>

@endsection
