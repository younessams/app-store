import { v4 as uuidv4 } from 'uuid'

export function getGuestToken() {
  let token = localStorage.getItem('guest_token')
  if (!token) {
    token = uuidv4()
    localStorage.setItem('guest_token', token)
  }

  // Sync token to cookie for Laravel middleware
  document.cookie = `guest_token=${token}; path=/; max-age=${60 * 60 * 24 * 30}`

  return token
}
