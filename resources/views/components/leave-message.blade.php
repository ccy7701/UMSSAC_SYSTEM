<!-- resources/views/components/leave-message.blade.php -->
@if (session()->has('leave') || session()->has('error'))
    <div class="modal fade" id="flashModal" tabindex="-1" role="dialog" aria-labelledby="flashModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    @if (session()->has('leave'))
                        <div class="row text-center p-3">
                            <i class="text-muted fa fa-sign-out" style="font-size: 80px;"></i>
                        </div>
                        <div class="row text-center p-0">
                            <h4 class="rsans">Left club</h4>
                            <p class="rsans">{{ session('leave') ?? 'Process successful.' }}</p>
                        </div>
                    @elseif (session()->has('error'))
                        <div class="row text-center p-3">
                            <i class="text-danger fa-regular fa-circle-xmark" style="font-size: 80px;"></i>
                        </div>
                        <div class="row text-center p-0">
                            <h4 class="rsans">Error</h4>
                            <p class="rsans">{{ session('error') ?? 'Error encountered.' }}</p>
                        </div>
                        {{ session('error') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
