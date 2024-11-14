<!-- resources/views/components/added-sps.blade.php -->
@foreach ($addedstudypartners as $index => $record)
    <div class="row pb-3">
        <x-added-sp-list-item
            :record="$record"
            :type="$type"
            :intersectionarray="$intersectionarray"/>
    </div>
@endforeach
