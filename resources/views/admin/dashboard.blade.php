{{-- resources/views/admin/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100">
                    {{ __('Admin Dashboard') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Welcome back, ') . Auth::user()->name . '! Here\'s your system overview.' }}
                </p>
            </div>
            <div class="mt-4 sm:mt-0 flex items-center space-x-3">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ now()->format('l, F j, Y') }}
                </div>
                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                <span class="text-sm text-green-600 dark:text-green-400 font-medium">{{ __('System Online') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Quick Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Members Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Total Anggota') }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $totalAnggota }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('Registered members') }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-blue-50 dark:bg-blue-900/20 px-6 py-3">
                    <a href="{{ route('admin.anggota.index') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors">
                        {{ __('Manage Members') }} →
                    </a>
                </div>
            </div>

            <!-- Total Savings Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Jumlah Transaksi Simpanan') }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $jumlahTransaksiSimpanan }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('Total records of savings') }}</p>
                        </div>
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 dark:bg-green-900/20 px-6 py-3">
                    <a href="{{ route('admin.simpanan.index') }}" class="text-sm font-medium text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300 transition-colors">
                        {{ __('View Savings') }} →
                    </a>
                </div>
            </div>

            <!-- Active Loans Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Pinjaman Aktif') }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $jumlahPinjamanAktif }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('Active loans') }}</p>
                        </div>
                        <div class="p-3 bg-orange-100 dark:bg-orange-900/30 rounded-full">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-orange-50 dark:bg-orange-900/20 px-6 py-3">
                    <a href="{{ route('admin.pinjaman.index') }}" class="text-sm font-medium text-orange-600 dark:text-orange-400 hover:text-orange-800 dark:hover:text-orange-300 transition-colors">
                        {{ __('Manage Loans') }} →
                    </a>
                </div>
            </div>

            <!-- Active Projects Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Proyek Aktif') }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $proyekAktif }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('Running projects') }}</p>
                        </div>
                        <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-full">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-50 dark:bg-purple-900/20 px-6 py-3">
                    <a href="{{ route('admin.proyek.index') }}" class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300 transition-colors">
                        {{ __('View Projects') }} →
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        {{ __('Quick Actions') }}
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <a href="{{ route('admin.anggota.index') }}" class="flex items-center p-3 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg mr-3 group-hover:bg-blue-200 dark:group-hover:bg-blue-900/50 transition-colors">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ __('Add New Member') }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Register a new cooperative member') }}</p>
                        </div>
                        <svg class="w-4 h-4 ml-auto text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>

                    <a href="{{ route('admin.pinjaman.index') }}" class="flex items-center p-3 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                        <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg mr-3 group-hover:bg-green-200 dark:group-hover:bg-green-900/50 transition-colors">
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ __('Process Loan') }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Review and approve loan applications') }}</p>
                        </div>
                        <svg class="w-4 h-4 ml-auto text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>

                    <a href="{{ route('admin.laporan.piutang.index') }}" class="flex items-center p-3 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg mr-3 group-hover:bg-indigo-200 dark:group-hover:bg-indigo-900/50 transition-colors">
                            <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ __('Generate Report') }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('View accounts receivable reports') }}</p>
                        </div>
                        <svg class="w-4 h-4 ml-auto text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('System Status') }}
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ __('Database') }}</span>
                        </div>
                        <span class="text-sm text-green-600 dark:text-green-400">{{ __('Operational') }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ __('Application Server') }}</span>
                        </div>
                        <span class="text-sm text-green-600 dark:text-green-400">{{ __('Running') }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ __('Backup System') }}</span>
                        </div>
                        <span class="text-sm text-green-600 dark:text-green-400">{{ __('Up to Date') }}</span>
                    </div>

                    <div class="pt-4 border-t border-gray-200 dark:border-gray-600">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Last system check:') }}
                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ now()->format('H:i') }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome Message -->
        <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-xl shadow-lg">
            <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 text-white">
                <div class="max-w-3xl">
                    <h3 class="text-2xl font-bold mb-2">{{ __('Welcome to Admin Panel') }}</h3>
                    <p class="text-white/90 mb-6">
                        {{ __('Manage your cooperative efficiently with our comprehensive admin tools. Monitor member activities, process loans, track savings, and generate detailed reports all from this dashboard.') }}
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.anggota.index') }}" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-sm font-medium transition-colors backdrop-blur-sm">
                            {{ __('Manage Members') }}
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                        <a href="{{ route('admin.simpanan.index') }}" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-sm font-medium transition-colors backdrop-blur-sm">
                            {{ __('View Savings') }}
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
