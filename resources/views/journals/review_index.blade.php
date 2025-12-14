<x-app-layout>
    <x-slot name="header">
        Review Jurnal Siswa
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="flex space-x-2 w-full md:w-auto overflow-x-auto">
                    <a href="{{ route('journal.review') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ !request('filter') ? 'bg-blue-100 text-blue-700' : 'text-gray-500 hover:bg-gray-100' }}">
                        📋 Semua Jurnal <span class="ml-1 bg-white px-2 py-0.5 rounded-full text-xs shadow-sm">{{ $countAll }}</span>
                    </a>
                    <a href="{{ route('journal.review', ['filter' => 'unreviewed']) }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('filter') == 'unreviewed' ? 'bg-yellow-100 text-yellow-700' : 'text-gray-500 hover:bg-gray-100' }}">
                        ⏳ Belum Direview <span class="ml-1 bg-white px-2 py-0.5 rounded-full text-xs shadow-sm">{{ $countUnreviewed }}</span>
                    </a>
                    <a href="{{ route('journal.review', ['filter' => 'reviewed']) }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('filter') == 'reviewed' ? 'bg-green-100 text-green-700' : 'text-gray-500 hover:bg-gray-100' }}">
                        ✅ Sudah Direview <span class="ml-1 bg-white px-2 py-0.5 rounded-full text-xs shadow-sm">{{ $countReviewed }}</span>
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($journals->isEmpty())
                <div class="bg-white rounded-xl shadow-sm p-12 text-center border border-dashed">
                    <p class="text-gray-500">Belum ada jurnal siswa yang perlu ditampilkan.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6">
                    @foreach($journals as $journal)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $journal->user->avatar ? asset('storage/'.$journal->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($journal->user->name) }}" class="w-10 h-10 rounded-full object-cover">
                                        <div>
                                            <h4 class="font-bold text-gray-800">{{ $journal->user->name }}</h4>
                                            <p class="text-xs text-gray-500">{{ $journal->user->class_name }} • {{ $journal->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-2xl">
                                        @switch($journal->mood)
                                            @case('Senang') 😄 @break
                                            @case('Sedih') 😢 @break
                                            @case('Marah') 😡 @break
                                            @case('Cemas') 😰 @break
                                            @default 😐
                                        @endswitch
                                    </div>
                                </div>

                                <h3 class="font-bold text-lg text-blue-700 mb-2">{{ $journal->title }}</h3>
                                <div class="text-gray-600 text-sm leading-relaxed mb-4 bg-gray-50 p-4 rounded-lg">
                                    {{ $journal->content }}
                                </div>

                                <div class="border-t pt-4">
                                    @php
                                        // Ambil feedback milik guru yang sedang login (dari relation yang sudah difilter di controller)
                                        $myFeedback = $journal->feedbacks->first();
                                    @endphp

                                    @if($myFeedback)
                                        <div class="bg-green-50 p-4 rounded-lg border border-green-100 mb-2">
                                            <p class="text-xs text-green-700 font-bold uppercase mb-1">Feedback Anda ({{ $myFeedback->created_at->format('d M, H:i') }})</p>
                                            <p class="text-sm text-gray-800">{{ $myFeedback->content }}</p>
                                        </div>
                                        <button onclick="document.getElementById('edit-fb-{{ $journal->id }}').classList.toggle('hidden')" class="text-xs text-blue-600 hover:underline">
                                            Edit Feedback
                                        </button>

                                        <form id="edit-fb-{{ $journal->id }}" action="{{ route('journal.feedback', $journal->id) }}" method="POST" class="hidden mt-2">
                                            @csrf
                                            <div class="flex gap-2">
                                                <textarea name="teacher_feedback" rows="2" class="w-full text-sm border-gray-300 rounded-lg">{{ $myFeedback->content }}</textarea>
                                                <button type="submit" class="bg-blue-600 text-white px-3 rounded-lg text-xs">Update</button>
                                            </div>
                                        </form>
                                    @else
                                        <form action="{{ route('journal.feedback', $journal->id) }}" method="POST">
                                            @csrf
                                            <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">Berikan Masukan</label>
                                            <div class="flex gap-2">
                                                <textarea name="teacher_feedback" rows="2" class="w-full text-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg" placeholder="Tulis masukan..." required></textarea>
                                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm self-start">
                                                    Kirim
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">{{ $journals->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
