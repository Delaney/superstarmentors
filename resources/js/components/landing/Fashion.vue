<template>
	<div class="relative min-h-screen">
		<div class="grid grid-cols-2 h-full">
			<div class="px-12 py-16">
				<h5 class="mb-10 text-3xl w-96 font-extrabold">Your Favourite <span class="font-bold">Skit Mentors on Social Media!</span></h5>

				<div class="grid grid-cols-4 gap-5 h-full items-center">
					<div v-for="mentor in mentors" :key="mentor.id">
						<img :src="mentor.avatar" :alt="mentor.name" class="p-2">
						<h6 class="text-xl font-bold text-center">{{mentor.name}}</h6>
						<div class="text-red-500 text-xl font-bold text-center" role="button">+ Follow</div>
					</div>
				</div>
			</div>
			<div class="h-full">
				<img class="w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="images/fashion.jpg" alt="">
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		const o = {
			name: 'Richard Mofe-Damijo',
			avatar: 'images/rmd.jpg',
			id: 1,
		};

		const a = [o, o, o, o];
		const b = a.map((v, i) => {
			const q = {};
			Object.assign(q, v);
			q.id += i;
			return q;
		});

		return {
			mentors: b,
		}
	}
}
</script>