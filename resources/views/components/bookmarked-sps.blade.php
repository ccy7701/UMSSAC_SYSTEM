<!-- resources/views/components/bookmarked-sps.blade.php -->
@foreach ($bookmarks as $index => $bookmark)
    <div class="row pb-3">
        <x-bookmarked-sp-list-item :bookmark="$bookmark"/>
    </div>
@endforeach
