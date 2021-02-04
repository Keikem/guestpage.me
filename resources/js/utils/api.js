import axios from 'axios'

export function login(user) {
    return axios.post('http://localhost:8000/api/auth/login', {
        headers: { 'content-type': 'application/x-www-form-urlencoded' },
        email: user.email,
        password: user.password
    })
}

export function register(newUser) {
    return axios.post('http://localhost:8000/api/auth/register', {
        headers: { 'content-type': 'application/x-www-form-urlencoded' },
        name: newUser.name,
        email: newUser.email,
        password: newUser.password,
        password_confirmation: newUser.password_confirmation,
    })
}

export function me(token) {
    return axios.post('http://localhost:8000/api/auth/me', {}, {
        headers: { 'Authorization': `Bearer ${token}` }
    })
}

export function logout(token) {
    return axios.post('http://localhost:8000/api/auth/logout', {}, {
        headers: { 'Authorization': `Bearer ${token}` }
    })
}

export function getComments() {
    return axios.get('http://localhost:8000/api/comments')
}

export function newComment(comment, token) {
    if (token) {
        return axios.post('http://localhost:8000/api/comments', {
            headers: { 'content-type': 'application/x-www-form-urlencoded' },
            title: comment.title,
            content: comment.content
        }, {
            headers: { 'Authorization': `Bearer ${token}` }
        })
    }
    else return axios.post('http://localhost:8000/api/comments', {
        headers: { 'content-type': 'application/x-www-form-urlencoded' },
        title: comment.title,
        content: comment.content
    })
}

export function editComment(comment, id) {
    return axios.put(`http://localhost:8000/api/comments/${id}`, {
        headers: { 'content-type': 'application/x-www-form-urlencoded' },
        title: comment.title,
        content: comment.content
    })
}

export function deleteComment(id) {
    return axios.delete(`http://localhost:8000/api/comments/${id}`, {
        headers: { 'content-type': 'application/x-www-form-urlencoded' }
    })
}