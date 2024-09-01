<!-- resources/views/components/flash-message.blade.php -->
@if (session()->has('success') || session()->has('error'))
    <div class="modal fade" id="flashModal" tabindex="-1" role="dialog" aria-labelledby="flashModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    @if (session()->has('success'))
                        <div class="row text-center p-3">
                            <i class="text-success fa-regular fa-circle-check" style="font-size: 80px;"></i>
                        </div>
                        <div class="row text-center p-0">
                            <h4 class="rsans">Success!</h4>
                            <p class=rsans">{{ session('success') ?? 'Process successful.' }}
                        </div>
                    @elseif (session()->has('error'))
                        <div class="row text-center p-3">
                            <i class="text-danger fa-regular fa-circle-xmark" style="font-size: 80px;"></i>
                        </div>
                        <div class="row text-center p-0">
                            <h4 class="rsans">Error</h4>
                            <p class="rsans">{{ session('error') ?? 'Error encountered.' }}
                        </div>
                        {{ session('error') }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            $('#flashModal').modal('show');
            setTimeout(function() {
                $('#flashModal').modal('hide');
            }, 5000);
        });
    </script>
@endif