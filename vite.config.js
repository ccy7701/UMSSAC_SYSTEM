import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import os from 'os';
import fs from 'fs';
import path from 'path';

// Function to recursively get all JS files from a directory
function getAllFiles(dirPath, files = []) {
    const items = fs.readdirSync(dirPath);
    for (const item of items) {
        const fullPath = path.join(dirPath, item);
        if (fs.statSync(fullPath).isDirectory()) {
            getAllFiles(fullPath, files);
        } else if (fullPath.endsWith('.js')) {
            files.push(fullPath);
        }
    }
    return files;
}

// Function to get the local network IP address
function getLocalIP() {
    const interfaces = os.networkInterfaces();
    for (const name of Object.keys(interfaces)) {
        for (const iface of interfaces[name]) {
            if (iface.family === 'IPv4' && !iface.internal) {
                return iface.address;
            }
        }
    }
}

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/suggester/addedListOperations.js',
                'resources/js/suggester/suggesterFormOperations.js',
                'resources/js/suggester/suggesterResultsOperations.js',
                'resources/js/timetableBuilder/addTimetableSlot.js',
                'resources/js/timetableBuilder/deleteTimetableSlot.js',
                'resources/js/timetableBuilder/editTimetableSlot.js',
                'resources/js/timetableBuilder/helperFunctions.js',
                'resources/js/timetableBuilder/timetableBuilderOperations.js',
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/js/clubsFinderSort.js',
                'resources/js/eventsFinderSort.js',
                'resources/js/facultyCoursesLoader.js',
                'resources/js/imageViewer.js',
                'resources/js/itemViewToggler.js',
                'resources/js/loginFormRoleSelector.js',
                'resources/js/manageMemberOperations.js',
                'resources/js/picturePreviewer.js',
                'resources/js/registerFormRoleSelector.js',
                'resources/js/semesterDropdown.js',
                'resources/js/semIdValidator.js',
                'resources/js/semSubOperations.js',
                'resources/js/systemUsersViewToggler.js',
                'resources/js/sysusersSort.js',
                'resources/js/tooltips.js'
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            host: getLocalIP(),
            port: 5173,
        },
    }
});
