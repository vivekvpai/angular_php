import { HttpClient, HttpResponse } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, map } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class CommonService {
  constructor(private httpClient: HttpClient) {}

  create_user(data: any): Observable<any> {

    console.log('in service', data)

    const url = 'http://localhost/ab/insert.php';
    return this.httpClient.post<any>(url, data).pipe(map((data) => data));
  }

  update_user(data: any): Observable<any> {

    console.log('in service', data)

    const url = 'http://localhost/ab/update.php';
    return this.httpClient.post<any>(url, data).pipe(map((data) => data));
  }

  get_user(user_name?: any): Observable<any> {

    console.log('in service', user_name)

    let url = 'http://localhost/ab/view.php';

    if (user_name) {
      url = 'http://localhost/ab/view.php?user_name=' + user_name;
    }

    return this.httpClient.get<any>(url).pipe(map((data) => data));
  }

  delete_user(user_name: any): Observable<any> {
    console.log('in service', user_name)

    let url = 'http://localhost/ab/delete.php?user_name=' + user_name;
    return this.httpClient.get<any>(url).pipe(map((data) => data));
  }
}      
