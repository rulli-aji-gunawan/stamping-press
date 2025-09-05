<x-app-layout>Edit Downtime Production Report</x-app-layout>

<meta name="csrf-token" content="{{ csrf_token() }}">

<x-downtime-edit-layout :production="$production" :models="$models" :years="$years" :items="$items" :processNames="$processNames"
    :dtCategories="$dtCategories" :dtClassifications="$dtClassifications" />

<script src="{{ asset('js/sidebar.js') }}"></script>
<script src="{{ asset('js/input-qty.js') }}"></script>
{{-- <script src="{{ asset('js/edit-downtime-tbl-row.js') }}"></script> --}}
<script src="{{ asset('js/edit-prod-tbl-row.js') }}"></script>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
