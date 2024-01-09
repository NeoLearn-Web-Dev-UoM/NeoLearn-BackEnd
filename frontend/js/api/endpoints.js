const BASE_URL = 'http://localhost/neolearn-backend/index.php';

const endpoints = {
    students: {
        login: BASE_URL + '/auth/student/login',
    },

    instructors: {
        login: BASE_URL + '/auth/instructor/login',
        signup: BASE_URL + '/instructors',
    },

    courses: {
        create: BASE_URL + '/courses',
        getAll: BASE_URL + '/courses',
        getById: BASE_URL + '/courses/search/id/',
        getByInstructorId: BASE_URL + '/courses/search/instructor/',
        delete: BASE_URL + '/courses/delete/',
        update: BASE_URL + '/courses',
    }
}

export {endpoints};