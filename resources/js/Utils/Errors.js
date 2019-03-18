class Errors {
  constructor(errors = {}) {
    this.record(errors)
  }

  record(errors = {}) {
    this.errors = errors
  }

  all() {
    return this.errors
  }

  any() {
    return Object.keys(this.errors).length > 0
  }

  has(key) {
    return key in this.errors
  }

  first(field) {
    return this.get(field)[0]
  }

  get(field) {
    return this.errors[field] || []
  }
}

export default Errors
