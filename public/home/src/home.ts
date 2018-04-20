import { RequestService } from './request';
import { Observable } from 'rxjs/Observable';
import { Page, PageController, PageServiceController } from './page';
import { ArticleLabel, Article } from './article';
import { Pagination, PageCtrl } from './paginate';
import 'rxjs/add/operator/skipWhile';
import 'rxjs/add/operator/do';
import 'rxjs/add/operator/combineLatest';
declare const $: any;

class HomeController extends PageServiceController implements PageController, PageCtrl {

    private homeLabelPadHtml: string;
    private homeArticlePadHtml: string;
    private page = new Pagination();

    onInit() {
        const requests = [];
        this.page.limit = 2;
        requests.push(this.request.get('/webblog/article/label/list').skipWhile(apiRes => apiRes.result === false)
            .do(res => {
                const labels = <ArticleLabel[]>res.datas;
                this.homeLabelPadHtml = '';
                labels.forEach(label => {
                    this.homeLabelPadHtml += this.getLabelDom(label);
                });
            }));
        requests.push(this.request.get('/webblog/article/list', this.page.pageData).skipWhile(apiRes => apiRes.result === false)
            .do(res => {
                const articles = res.datas.rows;
                this.page.total = res.datas.total;
                this.homeArticlePadHtml = '';
                articles.forEach(article => {
                    this.homeArticlePadHtml += this.getArticleDom(article);
                });
            }));
        requests[0].combineLatest(requests[1]).subscribe(() => {
            this.fillView();
        });
    }

    private loadArticle() {
        this.request.get('/webblog/article/list', this.page.pageData).skipWhile(apiRes => apiRes.result === false)
            .subscribe(res => {
                const articles = res.datas.rows;
                this.page.total = res.datas.total;
                this.homeArticlePadHtml = '';
                articles.forEach(article => {
                    this.homeArticlePadHtml += this.getArticleDom(article);
                });
                this.fillView();
            });
    }

    private fillView() {
        $('#home_label_pad').html(this.homeLabelPadHtml);
        $('#home_article_pad').html(this.homeArticlePadHtml);
        $('#pagination').html(this.page.getPaginationHtml());
    }

    private getLabelDom(label: ArticleLabel): string {
        return `<button class="btn btn-link" data-id="${label.id}">${label.articleLabelName}</button>`;
    }

    private getArticleDom(article: Article): string {
        return `<div style="width: 100%;background-color:white;padding:0px 5px;padding-top:5px;margin-bottom:20px;">
                    <img data-src="holder.js/100%x400" src="${article.articleThumb}" alt="..." style="width: 100%;">
                    <p class="text-left" style="padding:0px 5px;text-indent: 2em;">
                        <span>
                            <small>${article.articleContent}</small>
                        </span>
                    </p>
                    <p class="text-right text-muted" style="padding:0px 5px;">
                        <small>${article.updatedAt}</small>
                    </p>
                </div>`;
    }

    prevPage() {
        if (this.page.hasPrev()) {
            this.page.page--;
            this.loadArticle();
        }
    }

    nextPage() {
        if (this.page.hasNext()) {
            this.page.page++;
            this.loadArticle();
        }
    }

    goPage(index: number) {
        if (this.page.hasPage(index)) {
            this.page.page = index;
            this.loadArticle();
        }
    }
}

Page.create(new HomeController);
