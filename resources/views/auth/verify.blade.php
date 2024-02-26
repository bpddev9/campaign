<x-auth.authenticate>
    <div class="login-wapper">
        <h2>enter verification code</h2>
        <form action="" id="otp-input">
            @csrf
            @foreach (range(0,4) as $i)
            <input type="text" name="otp[]" id="otp-{{ $i }}">
            @endforeach
            <button type="submit" class="submit">Submit</button>
        </form>
    </div>
</x-auth.authenticate>
