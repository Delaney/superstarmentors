<template>
	<div>
		<div class="h-screen">
			<Navbar />
			<div class="relative h-5/6">
				<img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="images/hero.jpg" alt="">

				<div class="absolute left-0 top-0 mt-10 ml-10">
					<h2 class="text-3xl w-96 text-white font-bold">Superstar Mentors is the premium platform where celebrities mentor upcoming artists.</h2>
				</div>

				<div class="absolute bottom-0 w-full mb-4 px-2">
					<div class="relative flex flex-col w-4/5 mx-auto">
						<div class="text-white text-2xl uppercase py-2">Choose Your Mentors</div>
						<!-- <div class="flex">
							<input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Type in a name (e.g Ramsey Nouah)"/>
							<select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="" id=""></select>
							<button>Search</button>
							<button>View All</button>
						</div> -->

						<div class="grid grid-cols-3 gap-3">
							<div>
								<input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Type in a name (e.g Ramsey Nouah)"/>
							</div>
							<div>
								<select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="" id=""></select>
							</div>
							<div class="flex flex-row">
								<button class="w-1/2">Search</button>
								<button class="w-1/2">View All</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<Popular />
		<Upcoming />
		<Blog />
		<Skit />
		<Fashion />
	</div>
</template>

<script>
import Navbar from '../components/Navbar';
import Popular from '../components/landing/Popular';
import Upcoming from '../components/landing/Upcoming';
import Blog from '../components/landing/Blog';
import Skit from '../components/landing/Skit';
import Fashion from '../components/landing/Fashion';

export default {
	components: {
		Navbar,
		Popular,
		Upcoming,
		Blog,
		Skit,
		Fashion
	}
}
</script>