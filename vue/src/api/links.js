import request from '@/utils/request'

//findAll,deleteById,save
export function findAll() {
    return request({
        url: '/links/findAll',
        method: 'get',
    })
}

export function findById() {
    return request({
        url: '/links/findById',
        method: 'post'
    })
}

export function findByPage(pageCode, pageSize) {
    return request({
        url: '/links/findByPage',
        method: 'post',
        params: {
            pageCode,
            pageSize
        }
    })
}

export function save(obj) {
    return request({
        url: '/links/save',
        method: 'post',
        data: obj
    })
}

export function deleteById(ids) {
    return request({
        url: '/links/delete',
        method: 'post',
        data: ids
    })
}

export function update(obj) {
    return request({
        url: '/links/update',
        method: 'post',
        data: obj
    })
}

