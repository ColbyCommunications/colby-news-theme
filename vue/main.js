import { createApp } from 'vue';
import App from './App.vue';

import CryptoJS from 'crypto-js';
const colbyNews = window.colbyNews.sec;

function CryptoJSAesDecrypt(passphrase, encrypted_json_string) {
  var obj_json = encrypted_json_string;
  var encrypted = obj_json.ct;
  var salt = CryptoJS.enc.Hex.parse(obj_json.s);
  var iv = CryptoJS.enc.Hex.parse(obj_json.i);

  var key = CryptoJS.PBKDF2(passphrase, salt, {
    hasher: CryptoJS.algo.SHA512,
    keySize: 64 / 8,
    iterations: 999,
  });

  var decrypted = CryptoJS.AES.decrypt(encrypted, key, { iv: iv });

  return decrypted.toString(CryptoJS.enc.Utf8);
}

console.log(
  CryptoJSAesDecrypt(process.env.PLATFORM_VARIABLE_PASSPHRASE, colbyNews)
);

createApp(App).mount('#vue');
