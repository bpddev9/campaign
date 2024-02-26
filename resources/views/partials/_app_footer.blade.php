<footer class="fst-footer-new
@if (auth()->check())
     @if (auth()->user()->political_group === 'democrat')
     domocrat-class
     @elseif(auth()->user()->political_group === 'republican')
     republican-class
     @else
     footer-for-new-bg nonparty-class
     @endif
     @else
     footer-for-new-bg
@endif">

    <div class="container">
        <div class="footer-wapper">
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <p>Sponsored by <a href="#">Campaign Express</a></p>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <p> Design and Maintained <a href="#">Business Pro Digital</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>
