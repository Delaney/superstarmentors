<template>
	<div class="min-h-screen relative bg-white overflow-hidden grid grid-cols-2">
		<img class="h-full w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="/images/mentor-signup.png" alt="">
		<div class="max-w-7xl w-3/4 mx-auto">
			<div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-xl lg:w-full lg:pb-28 xl:pb-32">
				<main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
					<div class="">
						<h1 class="text-xl text-center tracking-tight font-extrabold text-gray-900 sm:text-2xl md:text-2xl">
							<span class="block xl:inline">Signup</span>
						</h1>

						<form class="shadow-md rounded px-8 pt-6 pb-8 mb-4">
							<div class="mb-4">
								<label class="block text-gray-700 text-sm font-bold mb-2" for="full_name">
									Full Name
								</label>
								<input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="full_name" type="text" placeholder="Full Name" v-model="fullName">
							</div>
							<div class="mb-4">
								<label class="block text-gray-700 text-sm font-bold mb-2" for="email">
									Email
								</label>
								<input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="Email" v-model="email">
							</div>
							<div class="mb-6">
								<label class="block text-gray-700 text-sm font-bold mb-2" for="password">
									Password
								</label>
								<input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="******************" v-model="password">
							</div>
							<div class="flex items-center justify-between">
								<button class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline uppercase" type="button" @click="sendSignup">
									Sign Up
								</button>
								<!-- <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
									Forgot Password?
								</a> -->
							</div>
						</form>
					</div>
				</main>
			</div>
		</div>
	</div>
</template>

<script>
import axios from 'axios';
export default {
	data() {
		return {
			fullName: '',
			email: '',
			password: '',
			category: ''
		}
	},

	beforeMount() {
		if (localStorage.getItem('mentor')) {
			this.$router.push('/mentor');
		}
	},

	methods: {
		sendSignup() {
			const data = {
				name: this.fullName,
				email: this.email,
				password: this.password,
				category: 'mentor'
			};

			axios.post('/api/mentor/signup', data)
				.then(response => response.data)
				.then(data => {
					console.log(data);
					localStorage.setItem('mentor', data.api_token);
					this.$router.push('/mentor');
				});
		},
	}
}
</script>