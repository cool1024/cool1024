import { RequestService } from './utils/request';
import { Page, PageServiceController } from './utils/page';
import './style.scss';

declare const $: any;

class IndexController extends PageServiceController {

    content: string;

    onInit() {

    }

    fillView() {

    }
}
Page.create(new IndexController);   
