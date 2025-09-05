<x-app-layout>Input Production Report</x-app-layout>

<meta name="csrf-token" content="{{ csrf_token() }}">

<x-production-layout :models="$models"></x-production-layout>

<script src="{{ asset('js/input-qty.js') }}"></script>
<script src="{{ asset('js/sidebar.js') }}"></script>
<script src="{{ asset('js/prod-tbl-row.js') }}"></script>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
