export interface DataDate {
    date:string;
    cases: {
        new: number;
        total: number;
    };
    deaths: {
        new: number;
        total: number;
    }
}