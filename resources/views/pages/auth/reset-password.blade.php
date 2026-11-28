<x-layout.app title="Reset Password">

    <div class="min-h-screen flex items-center justify-center p-6 bg-slate-100">
        <div class="w-full max-w-md">
            <x-ui.card title="Reset Password">
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <x-ui.input
                            name="email"
                            label="Email"
                            type="email"
                            placeholder="example@gmail.com"
                            required
                            value="{{ old('email', request('email')) }}"
                        />
                    </div>

                    <div class="mb-3">
                        <x-ui.input
                            name="password"
                            label="Password Baru"
                            type="password"
                            placeholder="********"
                            min="3"
                            required
                        />
                    </div>

                    <div class="mb-4">
                        <x-ui.input
                            name="password_confirmation"
                            label="Konfirmasi Password"
                            type="password"
                            placeholder="********"
                            min="3"
                            required
                        />
                    </div>

                    <x-ui.button variant="primary" type="submit">
                        Reset Password
                    </x-ui.button>
                </form>
            </x-ui.card>
        </div>
    </div>

</x-layout.app>