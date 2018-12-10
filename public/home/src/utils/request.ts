import { AppConfig } from '../config/app.config';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/observable/dom/ajax';
import 'rxjs/add/operator/map';

export interface ApiData {
    result: boolean,
    message: string | { [key: string]: string[] },
    datas: any,
}

export class ApiResponse implements ApiData {
    result: boolean;
    message: string | { [key: string]: string[] };
    datas: any;
    setResult(result: boolean) {
        this.result = true;
    }
    setMessage(message: string) {
        this.message = message;
    }
    setData(datas: any) {
        this.datas = datas;
    }
    fromApiData(apiData: ApiData) {
        this.result = apiData.result;
        this.message = apiData.message;
        this.datas = apiData.datas;
    }
}

export enum HTTP_METHOD {
    get = 'GET',
    post = 'POST',
    put = 'PUT',
    delete = 'DELTE',
}

export declare class AjaxResponse {
    originalEvent: Event;
    xhr: XMLHttpRequest;
    request: any;
    /** @type {number} The HTTP status code */
    status: number;
    /** @type {string|ArrayBuffer|Document|object|any} The response data */
    response: any;
    /** @type {string} The raw responseText */
    responseText: string;
    /** @type {string} The responseType (e.g. 'json', 'arraybuffer', or 'xml') */
    responseType: string;
}

export class RequestService {

    get(url: string, params = {}): Observable<ApiData> {
        return this.http(HTTP_METHOD.get, AppConfig.HTTP_SERVER + url, params);
    }

    post(url: string, params = {}): Observable<ApiData> {
        return this.http(HTTP_METHOD.post, AppConfig.HTTP_SERVER + url, params);
    }

    http(method: HTTP_METHOD, url: string, body = {}, headers = {}): Observable<ApiData> {
        if (method === HTTP_METHOD.get || method === HTTP_METHOD.delete) {
            url += this.queryParamStr(body);
        }
        return Observable.ajax({ url: url, method: method, responseType: 'json', headers, body })
            .map<AjaxResponse, ApiData>(data => {
                const apiRes = new ApiResponse();
                if (data.status != 200) {
                    apiRes.setResult(false);
                } else {
                    apiRes.fromApiData(<ApiData>data.response);
                }
                return apiRes;
            });
    }

    private queryParamStr(json: any): string {
        let key: any;
        let query: string[] = new Array<string>()
        let str = ""
        for (key in json) {
            query.push(key + "=" + json[key])
        }
        str = query.join('&')
        return str === "" ? str : '?' + str
    }
}