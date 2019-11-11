export default class Response {
  constructor(status, message, data, meta, links) {
    this.status = status || null;
    this.message = message || null;
    this.data = data || null;

    this.meta = meta || null;
    this.links = links || null;
  }
}
