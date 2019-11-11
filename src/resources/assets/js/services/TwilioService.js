import {Device} from 'twilio-client';
import HttpService from './HttpService';

const handlers = {
  connect: [],
  error: [],
  offline: [],
  incoming: [],
  cancel: [],
  ready: [],
  disconnect: [],
};

// register event listeners
(function registerEvents(events) {
  events.forEach(event => {
    Device.on(event, e => {
      handlers[event].forEach(handler => handler(e));
    });
  });
})(Object.keys(handlers));

export default {
  // initialize twilio caller
  init(token_url) {
    HttpService
        .get(token_url)
        .then(response => {
          Device.setup(response.data.token);
        })
        .catch(error => {
          console.log(error);
        });
  },
  on(event, handler) {
    if (!handlers[event]) {
      throw new Error(`${event} is not supported`);
    }

    handlers[event].push(handler);
  },
  off(event, handler) {
    if (handlers[event].indexOf(handler) >= 0) {
      handlers[event].splice(handlers[event].indexOf(handler), 1);
    }
  },
  onConnect(handler) {
    this.on('connect', handler);
  },
  onError(handler) {
    this.on('error', handler);
  },
  onOffline(handler) {
    this.on('offline', handler);
  },
  onIncoming(handler) {
    this.on('incoming', handler);
  },
  onCancel(handler) {
    this.on('cancel', handler);
  },
  onReady(handler) {
    this.on('ready', handler);
  },
  onDisconnect(handler) {
    this.on('disconnect', handler);
  },
  connect(target) {
    Device.connect({To: target});
  },
  disconnect() {
    Device.disconnectAll();
  },
  getDevice() {
    return Device;
  },
};