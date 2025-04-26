document.addEventListener('DOMContentLoaded', async function () {
    const filterButton = document.getElementById('filter-button');
    const jobListingsContainer = document.querySelector('.job-listings');
    const filterLocation = document.getElementById('filter-location');
    const filterSalary = document.getElementById('filter-salary');
    
    // Fetch locations from the API and populate the location filter
    // This function fetches the locations from the API and populates the location filter dropdown
    const fetchLocations = async () => {
        try {
            const response = await fetch('/wp-json/job-board-mini/v1/locations/');
            const locations = await response.json();
            locations.forEach(location => {
                const option = document.createElement('option');
                option.value = location;
                option.textContent = location;
                filterLocation.appendChild(option);
            });
        } catch (error) {
            console.error('Error fetching locations:', error);
        }
    };

    // Fetch jobs from the API based on the selected location and salary
    // This function fetches the jobs from the API based on the selected location and salary
    const fetchJobs = async (location, salary) => {
        try {
            let url = '/wp-json/job-board-mini/v1/jobs/';
            const params = new URLSearchParams();
            if (location) params.append('location', location);
            if (salary) params.append('salary', salary);
            url += '?' + params.toString();

            const response = await fetch(url);
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error fetching jobs:', error);
            return [];
        }
    };

    // Render the job listings in the container
    // This function renders the job listings in the container
    const renderJobs = (jobs) => {
        jobListingsContainer.innerHTML = '';  

        if (jobs.length === 0) {
            jobListingsContainer.innerHTML = '<p>No jobs found.</p>';
            return;
        }

        const fragment = document.createDocumentFragment();

        jobs.forEach(({ title, description, location, salary, type }) => {
            const jobCard = document.createElement('div');
            jobCard.classList.add('p-6', 'bg-white', 'rounded-lg', 'shadow-md');
            jobCard.innerHTML = `
                <h3 class="text-3xl font-bold mb-2 md:text-2xl">${title}</h3>
                <p class="mb-2 text-3xl md:text-xl">${description}</p>
                <p class="text-gray-600 text-3xl md:text-xl">${location} – $${salary}</p>
                <p class="text-gray-600 text-3xl md:text-xl"> Job type ${type}</p>
            `;
            fragment.appendChild(jobCard);
        });

        jobListingsContainer.appendChild(fragment);
    };

    // Fetch all jobs on page load
    await fetchLocations();

    // Event listener for the filter button
    // This event listener fetches the jobs based on the selected location and salary when the filter button is clicked
    filterButton.addEventListener('click', async function () {
        const location = filterLocation.value;
        const salary = filterSalary.value;

        const jobs = await fetchJobs(location, salary);
        renderJobs(jobs);
    });
});
