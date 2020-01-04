import request from '@/utils/request'

export function findAllArticle() {
    return request({
        url: '/article/findAll',
        method: 'get',
    })
}

export function findById(id) {
    return request({
        url: '/article/findById',
        method: 'get',
        params: {
            id
        }
    })
}

export function findByPage(pageCode, pageSize) {
    return request({
        url: '/article/findByPage',
        method: 'post',
        params: {
            pageCode,
            pageSize
        }
    })
}

export function save(obj) {
    return request({
        url: '/article/save',
        method: 'post',
        data: obj
    })
}

export function update(obj) {
    return request({
        url: '/article/update',
        method: 'post',
        data: obj
    })
}

export function findByPageForSite(pageCode, pageSize) {
    return request({
        url: '/article/findByPageForSite',
        method: 'post',
        params: {
            pageCode,
            pageSize
        }
    })
}

export function search(title) {
    return request({
        url: '/article/search',
        method: 'get',
        params: {
            'title':title
        }
    })
}

export function deleteById(ids) {
    return request({
        url: '/article/delete',
        method: 'post',
        data: ids
    })
}

/**
 * article  /  comments
 * */
export function findCountByArticleId(id) {
    return request({
        url: '/article/findCountByArticleId?article_id=' + id,
        method: 'get',
    })
}
