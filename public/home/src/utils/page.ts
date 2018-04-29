
import { RequestService } from '../utils/request';
declare const window: any;
export interface PageController {
    request: RequestService;
    onInit(): void;
    fillView(): void;

}

export class PageServiceController implements PageController {
    request: RequestService;
    onInit() { }
    fillView() { }
}

export class Page {

    constructor() {

    }

    static create(ctr: PageController) {
        window.Page = ctr;
        window.PageHandle = () => {
            ctr.request = new RequestService();
            ctr.onInit();
        }
    }
}
