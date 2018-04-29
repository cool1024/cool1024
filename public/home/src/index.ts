import { RequestService } from './utils/request';
import { Page, PageServiceController } from './utils/page';
import './style.scss';

declare const $: any;

class IndexController extends PageServiceController {

    content: string;

    onInit() {
        $('.form-control').keyup(event => {
            this.content = event.target.value;
        });
    }

    fillView() {
        $('#pad').html(this.content);
    }
}
Page.create(new IndexController);   
