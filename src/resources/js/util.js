// クッキーの値を取得
export function getCookieValue(searchKey) {
    if (typeof searchKey === 'undefined') {
        return ''
    }

    let val = ''

    document.cookie.split(';').forEach(cookie => {
        const [key, value] = cookie.split('=')
        if (key === searchKey) {
            return val = value
        }
    })

    return val
}

export const OK = 200
export const CREATED = 201
export const NOT_FOUND = 404
export const UNAUTHORIZED = 419 // 認証切れ
export const UNPROCESSABLE_ENTITY = 422 //バリデーションエラー
export const INTERNAL_SERVER_ERROR = 500 //サーバーエラー