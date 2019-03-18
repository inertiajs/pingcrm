import axios from 'axios'
import Errors from '@/Utils/Errors'

class Form {
  constructor(fields = {}) {
    this.fields = fields
    this.sending = false
    this.errors = new Errors()
    this.http = axios.create({
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
    })
  }

  delete({ url, then }) {
    this.request(this.http.delete(url), then)
  }

  post({ url, data = this.fields, then }) {
    this.request(this.http.post(url, data), then)
  }

  put({ url, data = this.fields, then }) {
    this.request(this.http.put(url, data), then)
  }

  request(request, then) {
    this.sending = true

    request.then(response => {
      this.sending = false
      then(response.data)
    }).catch(error => {
      this.sending = false

      if (error.response && error.response.status === 422) {
        this.errors.record(error.response.data.errors)
      } else {
        return Promise.reject(error)
      }
    })
  }
}

export default Form
