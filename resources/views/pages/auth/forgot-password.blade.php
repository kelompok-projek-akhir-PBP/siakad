<x-layout.app title="Lupa Password">

    <div class="min-h-screen flex items-center justify-center p-6 bg bg-slate-100">
        <div class="w-full max-w-md">
            <x-ui.card title="Forgot Password">
                <form action="{{ route('password.email') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-ui.input
                            name="email"
                            label="Email"
                            type="email"
                            placeholder="example@gmail.com"
                            required
                            value="{{ old('email') }}"
                        />
                    </div>

                    <x-ui.button variant="primary" type="submit">
                        Send Password Reset Token
                    </x-ui.button>

                    <div class="mt-4 ml-5">
                        <a href="{{ route('login') }}" class="text-sm hover:underline">
                            Kembali ke Login
                        </a>
                    </div>
                </form>
            </x-ui.card>
        </div>
    </div>

</x-layout.app>