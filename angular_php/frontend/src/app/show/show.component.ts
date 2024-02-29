import { Component } from '@angular/core';
import { CommonService } from '../common.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-show',
  templateUrl: './show.component.html',
  styleUrls: ['./show.component.css'],
})
export class ShowComponent {
  constructor(private common: CommonService, private router: Router) {}

  user_list: any = [];

  remove(event: any) {
    this.common.delete_user(event).subscribe((res: any) => {
      this.user_list = res.data;
      console.log(res.data);
      this.ngOnInit();
    });
  }

  update(event: any) {
    this.router.navigate(['./update'], {
      queryParams: {
        user_name: event,
      },
    });
  }

  ngOnInit() {
    this.common.get_user().subscribe((res: any) => {
      this.user_list = res.data;
      console.log(res.data);
    });
  }
}
