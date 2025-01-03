import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',

                'resources/js/acadProgress/addSubject.js',
                'resources/js/acadProgress/helperFunctions.js',
                'resources/js/acadProgress/semesterDropdown.js',
                'resources/js/acadProgress/semIdValidator.js',
                'resources/js/acadProgress/semSubOperations.js',

                'resources/js/suggester/addedListOperations.js',
                'resources/js/suggester/suggesterFormOperations.js',

                'resources/js/timetableBuilder/addTimetableSlot.js',
                'resources/js/timetableBuilder/deleteTimetableSlot.js',
                'resources/js/timetableBuilder/editTimetableSlot.js',
                'resources/js/timetableBuilder/helperFunctions.js',
                'resources/js/timetableBuilder/timetableBuilderOperations.js',

                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/js/clubRequests.js',
                'resources/js/clubsFinderSort.js',
                'resources/js/eventsFinderSort.js',
                'resources/js/facultyCoursesLoader.js',
                'resources/js/flashModal.js',
                'resources/js/imageViewer.js',
                'resources/js/itemViewToggler.js',
                'resources/js/loginForm.js',
                'resources/js/manageMemberOperations.js',
                'resources/js/notificationOperations.js',
                'resources/js/picturePreviewer.js',
                'resources/js/registerForm.js',
                'resources/js/searchInputToggle.js',
                'resources/js/systemUsersViewToggler.js',
                'resources/js/sysusersSort.js',
                'resources/js/tooltips.js',
                'resources/js/updateProfilePicture.js'
            ],
            refresh: true,
        }),
    ],
});
