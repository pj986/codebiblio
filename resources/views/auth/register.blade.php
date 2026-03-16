<x-guest-layout>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />

            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
            />

            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>


        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>


        <!-- Password -->
        <div class="mt-4">

            <x-input-label for="password" :value="__('Password')" />

            <div style="display:flex;align-items:center">

                <input
                    id="password"
                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    onkeyup="checkPasswordStrength()"
                >

                <button
                    type="button"
                    onclick="togglePassword()"
                    style="margin-left:10px"
                >
                    👁
                </button>

            </div>

            <!-- Indicateur de force -->
            <p id="password-strength" style="font-size:12px;margin-top:6px"></p>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            <p style="font-size:12px;color:gray">
                Le mot de passe doit contenir :
                <br>• au moins 8 caractères
                <br>• une majuscule
                <br>• une minuscule
                <br>• un chiffre
                <br>• un caractère spécial
            </p>

        </div>


        <!-- Confirm Password -->
        <div class="mt-4">

            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

        </div>


        <div class="flex items-center justify-end mt-4">

            <a
                class="underline text-sm text-gray-600 hover:text-gray-900"
                href="{{ route('login') }}"
            >
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>

        </div>

    </form>



<script>

function togglePassword() {

    const password = document.getElementById("password");

    if(password.type === "password"){

        password.type = "text";

    }else{

        password.type = "password";

    }

}


function checkPasswordStrength() {

    const password = document.getElementById("password").value;

    const strengthText = document.getElementById("password-strength");

    let strength = 0;

    if(password.length >= 8) strength++;

    if(password.match(/[a-z]/)) strength++;

    if(password.match(/[A-Z]/)) strength++;

    if(password.match(/[0-9]/)) strength++;

    if(password.match(/[@$!%*#?&]/)) strength++;

    if(strength <= 2){

        strengthText.innerHTML = "Password strength: Weak";

        strengthText.style.color = "red";

    }
    else if(strength <= 4){

        strengthText.innerHTML = "Password strength: Medium";

        strengthText.style.color = "orange";

    }
    else{

        strengthText.innerHTML = "Password strength: Strong";

        strengthText.style.color = "green";

    }

}

</script>


</x-guest-layout>