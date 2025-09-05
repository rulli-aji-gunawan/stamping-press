<x-app-layout>Edit Production Report</x-app-layout>

<meta name="csrf-token" content="{{ csrf_token() }}">

<x-production-edit-layout :production="$production" :models="$models" :years="$years" :items="$items" :selectedItem="$selectedItem" :pictures="$pictures" :processNames="$processNames" :dtCategories="$dtCategories" :dtClassifications="$dtClassifications" />

<script src="{{ asset('js/sidebar.js') }}"></script>
<script src="{{ asset('js/input-qty.js') }}"></script>
<script src="{{ asset('js/edit-prod-tbl-row.js') }}"></script>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
