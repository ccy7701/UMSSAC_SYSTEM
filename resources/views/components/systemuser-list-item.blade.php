<!-- resources/views/components/systemuser-list-item.blade.php -->
<div class="rsans card systemuser-list-item" data-category="{{ $user->profile_faculty }}" data-account-role="{{ $user->account_role }}">
    {{ $user->account_full_name }}
</div>
