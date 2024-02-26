<x-auth.authenticate>
    <div class="arrow">
        @if (auth()->user()->role === 'applicant')
            <a href="{{ route('my.profile') }}"></a>
        @else
            <a href="{{ route('company.profile') }}"></a>
        @endif
    </div>
    <div class="login-wapper question-area-main">
        @error('answer')
        <span class="text-warning fw-bold">{{ $message }}</span>
        @enderror
        <form action="{{ route('profile.question.store') }}" method="POST" id="question-form">
            @csrf
            <div class="question-area-wapper">
                <div class="row">
                    @foreach ($questions as $key => $question)
                        <div class="col-lg-12">
                            <label for="">{{ $question }}</label>
                            <textarea style="border-radius: 10px; padding: 10px;" name="answer[{{ $key }}]" id="question-{{ $key }}">{{ isset($profileQs[$key - 1]['question']) && $profileQs[$key - 1]['question'] == $key ? $profileQs[$key - 1]['answer'] : '' }}</textarea>
                        </div>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="finish" style="background-color: #dde2e3;">Finish</button>
        </form>
    </div>
</x-auth.authenticate>
