import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { GoogleLinechartComponent } from './google-linechart.component';

describe('GoogleLinechartComponent', () => {
  let component: GoogleLinechartComponent;
  let fixture: ComponentFixture<GoogleLinechartComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ GoogleLinechartComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(GoogleLinechartComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
