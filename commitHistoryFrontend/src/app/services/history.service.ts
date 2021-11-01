import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { CommitHistory } from './../interfaces/commitHistory';
import { serverAppURL } from './../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class HistoryService {

  headerDict = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Access-Control-Allow-Headers': 'Content-Type',
  }
  
  requestOptions = {                                                                    
    headers: new HttpHeaders(this.headerDict), 
  };
  constructor( private http: HttpClient ) { }

  
  async getCommitsHistroy(author?: string): Promise<Array<CommitHistory>> {
    console.log('aaaaaaa : ', author);

    const data = {
      params: {
        author
      }
    }
    return await this.http.get<Array<CommitHistory>>(serverAppURL + 'fetchHistory', data )
    .toPromise();
  }
}
