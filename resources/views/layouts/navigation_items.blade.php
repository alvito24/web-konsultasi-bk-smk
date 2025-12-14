@php
    $activeClass = 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 font-semibold';
    $inactiveClass = 'text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200';
@endphp

<div class="space-y-1">
    <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3 text-sm {{ request()->routeIs('dashboard') ? $activeClass : $inactiveClass }}">
        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
        Dashboard
    </a>

    @if(Auth::user()->role === 'admin')
        <p class="px-4 pt-4 pb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Master Data</p>

        <a href="{{ route('admin.students.index') }}" class="group flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.students.*') ? $activeClass : $inactiveClass }}">
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.students.*') ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Data Siswa
        </a>
        <a href="{{ route('admin.teachers.index') }}" class="group flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.teachers.*') ? $activeClass : $inactiveClass }}">
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.teachers.*') ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            Data Guru
        </a>
    @endif

    <p class="px-4 pt-4 pb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Layanan</p>

    @if(Auth::user()->role === 'guru_bk')
        <a href="{{ route('counseling.schedule') }}" class="group flex items-center px-4 py-3 text-sm {{ request()->routeIs('counseling.schedule') ? $activeClass : $inactiveClass }}">
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('counseling.schedule') ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Jadwal Saya
        </a>

        <a href="{{ route('admin.monitoring.schedules') }}" class="group flex items-center px-4 py-3 text-sm {{ request()->routeIs('admin.monitoring.schedules') ? $activeClass : $inactiveClass }}">
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.monitoring.schedules') ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            Jadwal Guru Lain
        </a>
    @endif

    @if(in_array(Auth::user()->role, ['guru_bk', 'wali_kelas']))
        <a href="{{ route('journal.review') }}" class="group flex items-center px-4 py-3 text-sm {{ request()->routeIs('journal.review') ? $activeClass : $inactiveClass }}">
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('journal.review') ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            Review Jurnal
        </a>
    @endif

    @if(Auth::user()->role === 'siswa')
        <a href="{{ route('counseling.create') }}" class="group flex items-center px-4 py-3 text-sm {{ request()->routeIs('counseling.*') ? $activeClass : $inactiveClass }}">
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('counseling.*') ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            Booking Konseling
        </a>
    @endif

    @if(Auth::user()->role === 'wali_kelas')
        <a href="{{ route('wali.booking.create') }}" class="group flex items-center px-4 py-3 text-sm {{ request()->routeIs('wali.booking.*') ? $activeClass : $inactiveClass }}">
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('wali.booking.*') ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Booking Konseling
        </a>
    @endif

    @if(Auth::user()->role === 'siswa')
        <a href="{{ route('journal.index') }}" class="group flex items-center px-4 py-3 text-sm {{ request()->routeIs('journal.*') ? $activeClass : $inactiveClass }}">
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('journal.*') ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Jurnal Harian
        </a>
    @endif

    @if(in_array(Auth::user()->role, ['siswa', 'guru_bk', 'wali_kelas']))
        <a href="{{ route('materials.index') }}" class="group flex items-center px-4 py-3 text-sm {{ request()->routeIs('materials.*') ? $activeClass : $inactiveClass }}">
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('materials.*') ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            Bank Materi
        </a>
    @endif

    <a href="{{ route('forum.index') }}" class="group flex items-center px-4 py-3 text-sm {{ request()->routeIs('forum.*') ? $activeClass : $inactiveClass }}">
        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('forum.*') ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
        Forum Diskusi
    </a>

    @if(Auth::user()->role === 'wali_kelas')
        <a href="{{ route('wali.students') }}" class="group flex items-center px-4 py-3 text-sm {{ request()->routeIs('wali.students') ? $activeClass : $inactiveClass }}">
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('wali.students') ? 'text-blue-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Data Siswa Saya
        </a>
    @endif
</div>
