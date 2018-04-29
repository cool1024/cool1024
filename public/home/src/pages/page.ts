
import { RequestService } from '../utils/request';
declare const window: any;
export interface PageController {
    request: RequestService;
    onInit(): void;
}

export class PageServiceController {
    request: RequestService;
}

export class Page {

    constructor() {

    }

    static create(ctr: PageController) {
        window.Page = ctr;
        ctr.request = new RequestService();
        ctr.onInit();
    }
}
