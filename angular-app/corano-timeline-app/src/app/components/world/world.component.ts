import { DataDate } from './../../core/models/data.model';
import { Country } from './../../core/models/country.model';
import { Observable } from 'rxjs';
import { ApiService } from './../../core/api.service';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-world',
  templateUrl: './world.component.html',
  styleUrls: ['./world.component.scss']
})
export class WorldComponent implements OnInit {
  public worldData: DataDate[];
  public countryData: Country[];
  public lineData;
  public columns;
  public lineColors;
  public fromDate;
  public dateToggle = false;
  private logged = false;
  private casesTotal = true;
  private deathsTotal = true;
  private casesNew = true;
  private deathsNew = true;

  public buttons = [{short:"ct", name: "Cases Total"},
        {short: "dt", name: "Deaths Total"},
        {short: "cn", name: "Cases New"},
        {short: "dn", name: "Death New"}
        ];

  constructor(private api: ApiService) { }

  ngOnInit(): void {
    this.api.getWorldData().subscribe(data => { this.worldData = data, this.makeLineWorldData()});
    this.api.getCountryData().subscribe(data => this.countryData = data);
  }

  makeLineWorldData(log = false, casesTotal=true, deathsTotal=true, casesNew=true, deathsNew=true) {
    let data = [];
    this.worldData.forEach(entry => {

      const pushArray = []
      if (this.fromDate) {
        const entryDate = Date.parse(entry.date);
        console.log(this.fromDate < entryDate);
        if(this.fromDate <= entryDate) {
          pushArray.push(entry.date);
          if (casesTotal) {
            pushArray.push(log ? Math.log10(entry.cases.total) : entry.cases.total);
          }
          if (deathsTotal) {
            pushArray.push(log ? Math.log10(entry.deaths.total) : entry.deaths.total);
          }
          if (casesNew) {
            pushArray.push(log ? Math.log10(entry.cases.new) : entry.cases.new);
          }
          if (deathsNew) {
            pushArray.push(log ? Math.log10(entry.deaths.new) : entry.deaths.new);
          }
        data.push(pushArray);
            
        }
      } else {
      pushArray.push(entry.date);
      if (casesTotal) {
        pushArray.push(log ? Math.log10(entry.cases.total) : entry.cases.total);
      }
      if (deathsTotal) {
        pushArray.push(log ? Math.log10(entry.deaths.total) : entry.deaths.total);
      }
      if (casesNew) {
        pushArray.push(log ? Math.log10(entry.cases.new) : entry.cases.new);
      }
      if (deathsNew) {
        pushArray.push(log ? Math.log10(entry.deaths.new) : entry.deaths.new);
      }
      data.push(pushArray);

      }


    }); 

    this.lineData = data;
    const columns = ['Date'];
    const lineColors = [];
      if (casesTotal) {
        columns.push('Cases Total');
        lineColors.push('blue');

      }
      if (deathsTotal) {
        columns.push('Deaths Total');
        lineColors.push('red');
      }
      if (casesNew) {
        columns.push('Cases New');
        lineColors.push('green');
      }
      if (deathsNew) {
        columns.push('Deaths New');
        lineColors.push('orange');
      }

    this.columns = columns;
    this.lineColors = lineColors;
  }

  dataToLog(event) {
    this.logged = event.checked;

    if (this.logged) {
      this.makeLineWorldData(true);
    } else {
      this.makeLineWorldData();
    }
  }

  ToggleDataSet(event, set) {

    switch(set) {
      case "ct":
        this.casesTotal = event.checked;
        break;
      case "dt":
        this.deathsTotal = event.checked;
        break;
      case "cn":
        this.casesNew = event.checked;
        break;
      case "dn":
        this.deathsNew = event.checked;
        break;
      default:

    }

    this.makeLineWorldData(this.logged, this.casesTotal, this.deathsTotal, this.casesNew, this.deathsNew);
  }

  setFromDate(event) {
    this.fromDate = Date.parse(event.value);
    console.log(this.fromDate);
    this.makeLineWorldData(this.logged, this.casesTotal, this.deathsTotal, this.casesNew, this.deathsNew);
  }

  resetFromDate(event) {
    this.dateToggle = event.checked
    if (this.dateToggle == false) {
      this.fromDate = null;
    this.makeLineWorldData(this.logged, this.casesTotal, this.deathsTotal, this.casesNew, this.deathsNew);
    }
  }

}
