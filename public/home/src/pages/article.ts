export interface ArticleLabel {
    id: number;
    articleLabelLevel: number;
    articleLabelName: string;
}

export interface Article {
    id: number;
    articleTitle: string;
    articleLabelId: number;
    articleContent: string;
    articleThumb: string;
    createdAt: string;
    updatedAt: string;
}