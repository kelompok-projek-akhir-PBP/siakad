<x-layout.master title="Lupa Password">
    <form action="{{ route('password.email') }}" method="POST" class="max-w-125 m-5">
        @csrf

        <div class="mb-3">
            <x-ui.input
                name="email"
                label="Email"
                type="email"
                placeholder="example@gmail.com"
                required
                value="{{ old('email') }}"
            />
        </div>

        <x-ui.button variant="primary" type="submit">Send Password Reset Token</x-ui.button>
    </form>
</x-layout.master>
