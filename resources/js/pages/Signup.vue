<template>
	<div class="min-h-screen relative bg-white overflow-hidden px-3 py-8 flex justify-center">
		<div class="flex flex-col">
			<div class="mb-32">
				<img class="block h-20 w-auto mx-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Workflow">
			</div>

			<h2 class="font-bold text-4xl uppercase">Please Choose Your Sign Up Type</h2>

			<div class="grid grid-cols-2 my-12">
				
				<router-link to="/mentor/signup">
					<div class="flex flex-col items-center justify-center bg-blue-500 rounded-full p-6 w-52 h-52 ml-10 mr-auto">
						<Group class=""/>
						<h3 class="text-white font-bold text-2xl uppercase">Mentor</h3>
					</div>
				</router-link>
				<router-link to="/mentor/signup">
					<div class="flex flex-col items-center justify-center bg-blue-500 rounded-full p-6 w-52 h-52 ml-10 mr-auto">
						<Group class=""/>
						<h3 class="text-white font-bold text-2xl uppercase">Mentee</h3>
					</div>
				</router-link>
			</div>
			
			<h4 class="text-center">Need help? Click here</h4>
		</div>

	</div>
</template>

<script>
import Group from '../components/svg/Group.vue'
export default {
	
	components: {
		Group
	}
}
</script>