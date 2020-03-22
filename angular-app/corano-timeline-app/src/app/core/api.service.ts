import { DataDate } from './models/data.model';
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Country } from './models/country.model';

@Injectable({providedIn: 'root'})
export class ApiService {
  constructor(private httpClient: HttpClient) { }
  
  public getCountryData(): Observable<Country[]>{
    return this.httpClient.get<Country[]>('http://localhost:8088/api/allCountries')
  }

  public getWorldData(): Observable<DataDate[]> {
    return this.httpClient.get<DataDate[]>('http://localhost:8088/api/worldData')
  }

}
