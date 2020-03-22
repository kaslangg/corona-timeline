export interface Timeline {
    date: string;
    data: {location: string, 
        cases: {
            new: number;
            total: number;
            },
        deaths: {
            new: number;
            total: number;
            }
        }[]
}