import request from '@/utils/request'

export function findAllComments() {
    return request({
        url: '/comments/findAll',
        method: 'get',
    })
}

export function findByPage(pageCode, pageSize) {
    return request({
        url: '/comments/findByPage',
        method: 'post',
        params: {
            pageCode,
            pageSize
        }
    })
}

export function save(obj) {
    return request({
        url: '/comments/save',
        method: 'post',
        data: obj
    })
}

export function findCommentsList(pageCode, pageSize, articleId, sort) {
    return request({
        url: '/comments/findCommentsList?pageCode=' + pageCode + '&pageSize=' + pageSize + '&article_id=' + articleId + '&sort=' + sort,
        method: 'get',
    })
}

export function deleteById(ids) {
    return request({
        url: '/comments/delete',
        method: 'post',
        data: ids
    })
}
